<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DepartamentoController;
use App\Http\Controllers\Api\EstadoController;
use App\Http\Controllers\Api\FacturacionController;
use App\Http\Controllers\Api\FavoritoController;
use App\Http\Controllers\Api\HabitacionController;
use App\Http\Controllers\Api\ProveedorController;
use App\Http\Controllers\Api\ReparacionController;
use App\Http\Controllers\Api\ReservaController;
use App\Http\Controllers\Api\ReservaDetalleController;
use App\Http\Controllers\Api\RolController;
use App\Http\Controllers\Api\ServicioController;
use App\Http\Controllers\Api\TarifaController;
use App\Http\Controllers\Api\TipoHabitacionController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\TareaController;
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
Route::middleware(['auth:sanctum', "role:admin"])->group(function () {
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
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post("/tarea", [TareaController::class, "asignarTarea"])->name("store.tarea");
    Route::put("/tarea/{id}", [TareaController::class, "updateTarea"])->name("upd.tarea");
    Route::delete("/tarea/{id}", [TareaController::class, "deleteTarea"])->name("delete.tarea");
});

//Favoritos
Route::middleware(['auth:sanctum', 'role:cliente'])->group(function () {
    Route::get("/misfavorito", [FavoritoController::class, "misFavoritos"])->name("");
    Route::get("/favorito", [FavoritoController::class, "store"])->name("");
    Route::get("/favorito/{id}", [FavoritoController::class, "destroy"])->name("");
});

//Reparaciones
Route::middleware(['auth:sanctum', 'role:admin|recepcionista'])->group(function () {
    Route::get("/reparaciones", [ReparacionController::class, "verReparaciones"]);
    Route::post("/reparaciones", [ReparacionController::class, "store"])->name("store.reparacion");
    Route::put("/finalizarreparacion/{id}", [ReparacionController::class, "TerminarReparacion"])->name("upd.reparacion");
    Route::put("/elegirreparacion", [ReparacionController::class, "reclamarReparacion"]);
});

//Servicios
Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::get("/servicios", [ServicioController::class, "index"])->name("index.servicio");
    Route::post("/servicio", [ServicioController::class, "store"])->name("store.servicio");
    Route::put("/servicio/{id}", [ServicioController::class, "update"])->name("upd.servicio");
    Route::delete("/servicio/{id}", [ServicioController::class, "destroy"])->name("destroy.servicio");
});

//Tarifas
Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::get("/tarifas", [TarifaController::class, "index"])->name("");
    Route::post("/tarifa", [TarifaController::class, "storeNuevaTarifa"])->name("");
    Route::put("/tarifa/{id}", [TarifaController::class, "update"])->name("");
});

//TipoHabitacion
Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::get("/tiposhabitacion", [TipoHabitacionController::class, "getAll"])->name("");
    Route::get("/tipohab", [TipoHabitacionController::class, "store"])->name("");
    Route::get("/tipohab/{id}", [TipoHabitacionController::class, "update"])->name("");
    Route::get("/tipohab/{id}", [TipoHabitacionController::class, "destroy"])->name("");
});

//Proveedores
Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::get("/proveedores", [ProveedorController::class, "index"])->name("");
    Route::get("/proveedor", [ProveedorController::class, "store"])->name("");
    Route::get("/proveedor/{id}", [ProveedorController::class, "update"])->name("");
    Route::get("/proveedor/{id}", [ProveedorController::class, "destroy"])->name("");
});

//Departamentos
Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::get("/departamentos", [DepartamentoController::class, "index"])->name("");
    Route::post("/departamento", [DepartamentoController::class, "store"])->name("");
    Route::put("/departamento/{id}", [DepartamentoController::class, "update"])->name("");
    Route::delete("/departamento/{id}", [DepartamentoController::class, "destroy"])->name("");
});

Route::middleware(['auth:sanctum', 'role:admin'])
    ->get("/personal", [UserController::class, "getAllPersonal"])->name("personal");
Route::middleware(['auth:sanctum', 'role:admin'])
    ->post("/personal", [UserController::class, "storePersonal"])->name("post.personal");
Route::get("/", [Habitaciones::class])->name("home.cliente");
Route::get("/recepcion", [Habitaciones::class])->name("dashboard.empresa");
