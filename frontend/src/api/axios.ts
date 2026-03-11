
import axios from "axios";


const api = axios.create({
    baseURL: 'http://localhost/Proyecto_IA2/hoteleria_Moron/public/api', // La URL de tu Laravel
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