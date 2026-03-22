<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\EstadoController;
use App\Http\Controllers\Api\FacturacionController;
use App\Http\Controllers\Api\HabitacionController;
use App\Http\Controllers\Api\ReservaController;
use App\Http\Controllers\Api\ReservaDetalleController;
use App\Http\Controllers\Api\RolController;
use App\Http\Controllers\Api\TipoHabitacionController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\TareaController;
use App\Models\Habitaciones;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware(["auth:sanctum"])->post('/logout', [AuthController::class, "logout"]);


Route::get("/estados", [EstadoController::class, "getAllEstados"])->middleware(["auth:sanctum"])->name("getAll.Estados");

Route::get("/tiposhabitacion", [TipoHabitacionController::class, "getAll"])->middleware(["auth:sanctum"])->name("getAll.tiposhabitacion");

//Roles
Route::middleware(['auth:sanctum', 'role:'])->group(function () {
    Route::get("/roles", [RolController::class, "index"]);
    Route::post("/roles", [RolController::class, "store"])->name("store.rol");
    Route::put("/rol/{id}", [RolController::class, "update"])->name("upd.rol");
    Route::delete("/rol/{id}", [RolController::class, "destroy"])->name("delete.rol");
});

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
Route::middleware(['auth:sanctum', 'role:'])->group(function () {
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

//Tareas
Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::post("/tarea/store", [TareaController::class, "asignarTarea"])->name("store.tarea");
    Route::put("/tarea/{id}", [TareaController::class, "updateTarea"])->name("upd.tarea");
    Route::delete("/tarea/{id}", [TareaController::class, "deleteTarea"])->name("delete.tarea");
});

//Favoritos
Route::middleware(['auth:sanctum', 'role:cliente'])->group(function () {
    Route::get("", [])->name("");
    Route::get("", [])->name("");
    Route::get("", [])->name("");
});

//Reparaciones
Route::middleware(['auth:sanctum', 'role:'])->group(function () {
    Route::get("", [])->name("");
    Route::get("", [])->name("");
    Route::get("", [])->name("");
});

//Servicios
Route::middleware(['auth:sanctum', 'role:'])->group(function () {
    Route::get("", [])->name("");
    Route::get("", [])->name("");
    Route::get("", [])->name("");
});

//Tarifas
Route::middleware(['auth:sanctum', 'role:'])->group(function () {
    Route::get("", [])->name("");
    Route::get("", [])->name("");
    Route::get("", [])->name("");
});

//TipoHabitacion
Route::middleware(['auth:sanctum', 'role:'])->group(function () {
    Route::get("", [])->name("");
    Route::get("", [])->name("");
    Route::get("", [])->name("");
});

//Proveedores
Route::middleware(['auth:sanctum', 'role:'])->group(function () {
    Route::get("", [])->name("");
    Route::get("", [])->name("");
    Route::get("", [])->name("");
});

//Departamentos
Route::middleware(['auth:sanctum', 'role:'])->group(function () {
    Route::get("", [])->name("");
    Route::get("", [])->name("");
    Route::get("", [])->name("");
});

Route::middleware(['auth:sanctum', 'role:admin'])
    ->get("/personal", [UserController::class, "getAllPersonal"])->name("personal");
Route::middleware(['auth:sanctum', 'role:admin'])
    ->post("/personal", [UserController::class, "storePersonal"])->name("post.personal");
Route::get("/", [Habitaciones::class])->name("home.cliente");
Route::get("/recepcion", [Habitaciones::class])->name("dashboard.empresa");
