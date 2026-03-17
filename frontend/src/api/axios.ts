
import axios from "axios";


export const urlApi = 'http://localhost/Sistema_Hotel/backend/public/api';
export const urlImage = "http://localhost/Sistema_Hotel/backend/public";

const api = axios.create({
    baseURL: urlApi, // La URL de tu Laravel
    headers: {
        'Content-Type': 'application/json',
    }
});

// Interceptor para incluir el Token en cada petición
api.interceptors.request.use((config) => {
    const token = localStorage.getItem('token');
    console.log(token)
    if (token) {
        config.headers.Authorization = `Bearer ${token}`;
        console.log(config.headers.Authorization)
    }
    return config;
});



export default api;

