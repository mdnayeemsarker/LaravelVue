// // resources/js/axios.js

// import axios from 'axios';

// const axiosInstance = axios.create({
// baseURL: '/api', // Assuming your Laravel API endpoints are under /api route
// timeout: 10000, // Request timeout in milliseconds
// headers: {
// 'Content-Type': 'application/json',
// }
// });
// axiosInstance.interceptors.request.use(config => {
// const token = localStorage.getItem('_token');
// if (token) {
// config.headers.Authorization = `Bearer ${token}`;
// }
// return config;
// }, error => {
// return Promise.reject(error);
// });

// axiosInstance.interceptors.response.use(response => {
// return response.data.success;
// }, error => {
// if (error.response) {
// console.error('Error status:', error.response.status);
// console.error('Error data:', error.response.data);
// throw error;
// } else if (error.request) {
// console.error('Error request:', error.request);
// throw error;
// } else {
// console.error('Error message:', error.message);
// throw error;
// }
// });

// export default axiosInstance;


import axios from 'axios';

// Axios instance for GET requests
const axiosGet = axios.create({
    baseURL: '/api',
    timeout: 10000,
    headers: {
        'Content-Type': 'application/json',
    }
});

const axiosPost = axios.create({
    baseURL: '/api',
    timeout: 10000,
    headers: {
        'Content-Type': 'multipart/form-data',
    }
});

axiosGet.interceptors.request.use(config => { 
    const token = localStorage.getItem('_token');
    if (token) {
        config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
}, error => {
    return Promise.reject(error);
});

axiosPost.interceptors.request.use(config => {
    const token = localStorage.getItem('_token');
    if (token) {
        config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
}, error => {
    return Promise.reject(error);
});

axiosGet.interceptors.response.use(response => {
    return response.data.success;
}, error => {
    console.log(error);
});

axiosPost.interceptors.response.use(response => {
    return response.data.success;
}, error => {
    console.log(error);
});

export { axiosGet, axiosPost };
