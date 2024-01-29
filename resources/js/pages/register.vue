<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-6 mt-4">
                <h2>Register</h2>
                <p class="text-danger" v-for="error in errors" :key="error">
                    <span v-for="err in error" :key="err">{{ err }}</span>
                </p>
                <form @submit.prevent="register">
                    <div class="from-group">
                        <label for="name">Nane</label>
                        <input type="text" id="name" class="form-control" v-model="from.name">
                    </div>
                    <div class="from-group mt-2">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" class="form-control" v-model="from.email">
                    </div>
                    <div class="from-group mt-2">
                        <label for="password">Password</label>
                        <input type="password" id="password" class="form-control" v-model="from.password">
                    </div>
                    <div class="from-group mt-2">
                        <label for="confirm_password">Password</label>
                        <input type="confirm_password" id="confirm_password" class="form-control" v-model="from.confirm_password">
                    </div>
                    <button type="submit" class="btn btn-primary mt-2">Register</button>
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
            name: '',
            email: '',
            password: '',
            confirm_password: '',
        });
        let errors = ref([]);
        
        const register = async () => {
            try{
                await axios.post('/api/register', from).then(response => {
                    if (response.data.success) {
                        var data = response.data.success.data;
                        console.log(data);
                        store.dispatch('setToken', data.token);
                        route.push({ name: 'Dashboard' });
                    } else {
                        var errorRes = response.data.error;
                        errors.value = errorRes.data[0];
                        console.log(errorRes.data[0]);
                    }
                    // console.log(response);
                }).catch(error => {
                    // var errorRes = error;
                    // errors.value = errorRes.data;
                    // console.log(errorRes);
                    console.log(error);
                })
            }catch (error) {
                    console.error('API request failed', error);
                }
            };

        return {
            from,
            errors,
            register,
        };
    },
};
</script>
