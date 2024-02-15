<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-6 mt-4">
                <h2>Login</h2>
                <p class="text-danger" v-if="error">{{ error }}</p>
                <form @submit.prevent="login">
                    <div class="from-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" class="form-control" v-model="from.email">
                    </div>
                    <div class="from-group mt-2">
                        <label for="password">Password</label>
                        <input type="password" id="password" class="form-control" v-model="from.password">
                    </div>
                    <button type="submit" class="btn btn-primary mt-2">Login</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import { reactive, ref } from 'vue';
import { useRouter } from 'vue-router';
import { useStore } from 'vuex';
import axios from 'axios';

export default {
    setup() {
        const route = useRouter(); 
        const store = useStore(); 
        let from = reactive({
            email: '',
            password: '',
        });
        let error = ref('')
        
        const login = async () => {
            
            try {
                await axios.post('/api/login', from).then(response=>{
                    if (response.data.success) {
                        var data = response.data.success.data;
                        console.log(data);
                        store.dispatch('setToken', data.token);
                        route.push({ name: 'Dashboard' });
                    } else {
                        var errorRes = response.data.error;
                        error.value = errorRes.message;
                        console.log(errorRes);
                    }
                })
            }catch (error) {
                console.error('API request failed', error);
            }
        }

        return {
            from,
            error,
            login,
        };
    },
};
</script>
