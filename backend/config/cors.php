<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */


    /*
    | Rutas donde los CORS estarán activos. 
    | Asegúrate de incluir 'api/*' y la ruta de Sanctum si planeas usarlo para autenticación.
    */
    'paths' => ['api/*', 'sanctum/csrf-cookie'],
    /*
    | Métodos HTTP permitidos (GET, POST, PUT, DELETE, etc.).
    */
    'allowed_methods' => ['*'],
    /*
    | Aquí debes poner la URL exacta donde corre tu frontend en React (usualmente Vite usa el puerto 5173).
    | Puedes usar ['*'] para permitir todo en desarrollo, pero es mejor ser específico.
    */
    'allowed_origins' => ['http://localhost:5173', 'http://127.0.0.1:5173'],
    /*  
    | Para permitir expresiones regulares en los orígenes.
    */
    'allowed_origins_patterns' => [],
    /*
    | Cabeceras permitidas.
    */
    'allowed_headers' => ['*'],
    /*
    | Cabeceras expuestas al navegador.
    */
    'exposed_headers' => [],
    /*
    | Tiempo en caché para la respuesta preflight de CORS.
    */
    'max_age' => 0,
    /*
    | MUY IMPORTANTE: Cambia esto a 'true' si vas a manejar sesiones, 
    | cookies o autenticación con Laravel Sanctum desde React.
    */
    'supports_credentials' => true,

];
