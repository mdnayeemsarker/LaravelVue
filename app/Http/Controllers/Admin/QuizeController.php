<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quize;
use App\Models\Upload;
use App\Traits\AppResponse;
use App\Traits\HttpCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class QuizeController extends Controller
{
    use AppResponse;
    protected $user_id;
    protected $user;
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $user = Auth::user();
            if ($user) {
                $this->user = $user;
                $this->user_id = $this->user->id;
            }
            return $next($request);
        });
    }

    protected function all_quize() {
        $quizzes = Quize::all();
        if ($quizzes->isEmpty()) {
            return $this->apiresponse([], true, 'No quizzes found', HttpCode::HTTP_OK);
        }
        return $this->apiresponse(['quizzes' => $quizzes], true, 'Quizzes retrieved successfully', HttpCode::HTTP_OK);
    }    
    protected function all_image() {
        $uploads = Upload::all();
        if ($uploads->isEmpty()) {
            return $this->apiresponse([], true, 'No Images found', HttpCode::HTTP_OK);
        }
        return $this->apiresponse(['uploads' => $uploads, 'count' => $uploads->count()], true, 'Uploads retrieved successfully', HttpCode::HTTP_OK);
    }    
    // protected function store_quize(Request $request) {
    //     $quize = Quize::create([
    //         'user_id' => $this->user_id,
    //         'title' => $request->title,
    //         'description' => $request->description,
    //         'duration' => $request->duration,
    //         'question' => $request->question,
    //         'points' => $request->points,
    //         'type' => 'ssc',
    //     ]);
    //     if ($quize) {
    //         return $this->apiresponse([], true, 'Data Added successfull', HttpCode::HTTP_OK);
    //     } else {
    //         return $this->apiresponse([], false, 'Faield', HttpCode::HTTP_BAD_GATEWAY);
    //     } 
    // }
    protected function store_quize(Request $request): JsonResponse {
        $validatedData = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'duration' => 'required|string',
            'question' => 'required|string',
            'points' => 'required|string',
        ]);
    
        $quize = Quize::create([
            'user_id' => $this->user_id,
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'duration' => $validatedData['duration'],
            'question' => $validatedData['question'],
            'points' => $validatedData['points'],
            'type' => 'ssc',
        ]);
    
        if ($quize instanceof Quize && $quize->exists) {
            return $this->apiresponse([], true, 'Data Added successfully', HttpCode::HTTP_OK);
        } else {
            return $this->apiresponse([], false, 'Failed to add data', HttpCode::HTTP_BAD_GATEWAY);
        }
    }
    protected function store_quize2(Request $request) {
        $quize = Quize::create([
            'user_id' => $this->user_id,
            'title' => $request->title,
            'description' => $request->description,
            'duration' => $request->duration,
            'question' => $request->question,
            'points' => $request->points,
            'type' => 'hsc',
        ]);
        if ($quize) {
            return $this->apiresponse([], true, 'Data Added successfull', HttpCode::HTTP_OK);
        } else {
            return $this->apiresponse([], false, 'Faield', HttpCode::HTTP_BAD_GATEWAY);
        }
    }
}
