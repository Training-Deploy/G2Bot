import axios from 'axios';
import { app } from './app';

const baseUrl = '/';

const Repository = axios.create({
    baseUrl,
    headers: {
        'Content-Type': 'application/json',
    },
    json: true,
});

Repository.interceptors.request.use(function (config) {
    app.$root.isLoading = true;
    return config;
}, function (error) {
    app.$root.isLoading = false;
    return Promise.reject(error);
});

Repository.interceptors.response.use(function (response) {
    app.$root.isLoading = false;
    app.$root.handleSuccess(response);
    return response;
}, function (error) {
    app.$root.handleError(error);
    app.$root.isLoading = false;
    return Promise.reject(error);
});

export default Repository;
