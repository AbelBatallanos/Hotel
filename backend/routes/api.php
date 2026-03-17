<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\EstadoController;
use App\Http\Controllers\Api\FacturacionController;
use App\Http\Controllers\Api\HabitacionController;
use App\Http\Controllers\Api\ReservaController;
use App\Http\Controllers\Api\ReservaDetalleController;
use App\Http\Controllers\Api\TipoHabitacionController;
use App\Http\Controllers\Api\UserController;
use App\Models\Habitaciones;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, "logout"]);


Route::get("/estados", [EstadoController::class, "getAllEstados"])->middleware(["auth:sanctum"])->name("getAll.Estados");

Route::get("/tiposhabitacion", [TipoHabitacionController::class, "getAll"])->middleware(["auth:sanctum"])->name("getAll.tiposhabitacion");

//Reservaciones
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get("/reservaciones", [ReservaController::class, "geAllReservaciones"]);
    Route::get("/myreservas", [ReservaController::class, "getMisReservaciones"]);
    Route::get("/reserva/{reserva}/detalles", [ReservaController::class, "showReservaDetalles"])->name("show.detalles");

    Route::post("/reservacion", [ReservaController::class, "storeReservacion"]);

    Route::put("/reservacion/{reserva}", [ReservaController::class, "updateReservacionById"])->name("edit.reserva");

    Route::delete("/reservacion/{reserva}", [ReservaController::class, "delete"])->name("delete.reserva");
});

//ReservaDetalles
Route::middleware(['auth', 'second'])->group(function () {
    Route::delete('/detalle/{id}', [ReservaDetalleController::class, "destroy"]);
});

//Habitaciones
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get("/habitaciones", [HabitacionController::class, "getAllHabitaciones"])->name("getAll.Habitaciones");
    Route::get("/habitacion/{habitacion}", [HabitacionController::class, "showHabitacion"])->middleware("role:cliente|recepcionista")->name("show.habitacion");

    Route::post("/habitacion", [HabitacionController::class, "storehabitacion"]);
    Route::put("/habitacion/{habitacion}", [HabitacionController::class, "updateHabitacion"])->middleware("role:admin")->name("edit.habitacion");
    Route::delete("/habitacion/{habitacion}", [HabitacionController::class, "destroy"])->name("delete.habitacion");
});

//Facturas
Route::middleware(['auth:sanctum', 'role:recepcionista|admin'])->group(function () {
    Route::get("/facturas", [FacturacionController::class, "index"])->name("index.facturas");
    Route::post("/facturacion/{reserva}", [FacturacionController::class, "store"])->name("post.factura");
});



Route::middleware(['auth:sanctum', 'role:admin'])->get("/personal", [UserController::class, "getAllPersonal"])->name("personal");
Route::middleware(['auth:sanctum', 'role:admin'])->post("/personal", [UserController::class, "storePersonal"])->name("post.personal");
Route::get("/", [Habitaciones::class])->name("home.cliente");
Route::get("/recepcion", [Habitaciones::class])->name("dashboard.empresa");
