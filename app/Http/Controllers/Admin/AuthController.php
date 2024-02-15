<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Friend;
use App\Models\Notification;
use App\Models\Profile;
use App\Models\SocialLink;
use App\Models\User;
use App\Traits\AppResponse;
use App\Traits\HttpCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    use AppResponse;
    public function login(Request $request)
    {
        $roules = [
            'email' => 'required',
            'password' => 'required',
        ];
        $validator = Validator::make($request->all(), $roules);
        if ($validator->fails()) {
            return $this->apiresponse(
                [
                    $validator->errors()
                ],
                false,
                'You need to fill all the data',
                HttpCode::HTTP_BAD_REQUEST,
            );
        } else {
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                $user = User::find(Auth::user()->id);
                $token = $user->createToken('API Token of ' . $user->name)->plainTextToken;
                User::where('id', $user->id)->update(['remember_token' => $token]);
                return $this->apiresponse(
                    [
                        'user' => $user,
                        'token' => $token,
                    ],
                    true,
                    'You have successfully logged in.!',
                    HttpCode::HTTP_OK,
                );
            } else {
                return $this->apiresponse('', false, 'Credentials does not match', HttpCode::HTTP_UNAUTHORIZED);
            }
        }

        
    }
    // Register function start
    public function register(Request $request)
    {
        $roules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ];
        $validator = Validator::make($request->all(), $roules);
        if ($validator->fails()) {
            return $this->apiresponse(
                [
                    $validator->errors()
                ],
                false,
                'You need to fill all the data',
                HttpCode::HTTP_BAD_REQUEST,
            );
        } else {
            $user = User::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
            ]);
        }
        return $this->apiresponse(
            [
                'user' => $user,
                'token' => $user->createToken('API Token of ' . $user->name)->plainTextToken,
            ],
            true,
            'Congratulation, you have successfully created your account. Thank you for choosing RedRose Academy.!',
            HttpCode::HTTP_CREATED,
        );
    }
    // Logout start
    public function logout(Request $request)
    {
        $request
            ->user()
            ->currentAccessToken()
            ->delete();
        return $this->apiresponse('', true, 'You have successfully logout', 200);
    }
}
