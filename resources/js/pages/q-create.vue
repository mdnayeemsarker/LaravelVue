<template>
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Quize</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><router-link :to="{ name: 'Dashboard' }">Dashboard</router-link></li>
                            <li class="breadcrumb-item"><router-link :to="{ name: 'Quize' }">Quize</router-link></li>
                            <li class="breadcrumb-item active">Create Quize</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <form @submit.prevent="addData" enctype="multipart/form-data">
                            <div class="form-group">
                            <label for="title">Quize Title</label>
                            <input v-model="formData.title" type="text" required id="title" class="form-control">
                            </div>
                            <div class="form-group mt-2">
                            <label for="description">Description</label>
                            <input v-model="formData.description" type="text" id="description" class="form-control">
                            </div>
                            <div class="form-group mt-2">
                            <label for="duration">Duration</label>
                            <input v-model="formData.duration" type="text" id="duration" class="form-control">
                            </div>
                            <div class="form-group mt-2">
                            <label for="question">Question</label>
                            <input v-model="formData.question" type="text" id="question" class="form-control">
                            </div>
                            <div class="form-group mt-2">
                            <label for="points">Points</label>
                            <input v-model="formData.points" type="text" id="points" class="form-control">
                            </div>
                            <div class="form-group mt-2">
                            <label for="type">Type</label>
                            <input v-model="formData.type" type="text" id="type" class="form-control">
                            </div>
                            <div class="form-group mt-2">
                            <label for="image_url">Quize Image</label>
                            <input type="file" id="image_url" @change="onFileChange" class="form-control">
                            </div>
                            <div class="form-group mt-2">
                            <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                </div>
            </div>
        </div>
        <!-- Modal for adding new data -->
        <div class="modal fade" id="modal-lg">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add New Quize</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { axiosGet, axiosPost } from '../instance/axiosApi.js';
    export default {
        data() {
            return {
                formData: {
                    title: '',
                    description: '',
                    duration: '',
                    question: '',
                    points: '',
                    type: '',
                    image: null // For file upload
                },
            };
        },
        mounted() {
            this.fetchData();
        },
        methods: {
            addData() {
                const formData = new FormData();
                for (let key in this.formData) {
                    formData.append(key, this.formData[key]);
                }
                axiosPost.post('/store-quize', formData)
                    .then(response => {
                        console.log('Quiz added successfully', response);
                        this.resetFormData();
                        this.fetchData();
                    });
                },
                onFileChange(event) {
                    this.formData.image = event.target.files[0];
                },
                resetFormData() {
                for (let key in this.formData) {
                    this.formData[key] = '';
                }
                this.showModal = false;
            },
        }
    }
</script>
