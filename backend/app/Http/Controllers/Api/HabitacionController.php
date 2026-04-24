<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Habitacion\UpdateHabitacionRequest;
use App\Http\Resources\HabitacionResource;
use App\Models\Habitaciones;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use SebastianBergmann\CodeCoverage\Test\Target\Function_;

class HabitacionController extends Controller
{

    protected $imagen;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $habitaciones = Habitaciones::get();
        return response()->json(["habitaciones" => $habitaciones]);
    }

    public function getAllHabitaciones()
    {
        try {
            $habitaciones_disponibles = Habitaciones::with(["estado", "tipohabitacion"])->where("id_estado", 1)->orderBy("id", "DESC")->get();

            return response()->json([
                "estado" => 200,
                "habitaciones_disponibles" => HabitacionResource::collection($habitaciones_disponibles)
            ], 200);
        } catch (\Exception $e) {
            Log::error($e->getMessage() . "PEPE", ["file" => $e->getFile(), "codigo" => $e->getCode()]);
        }
    }


    public function storehabitacion(Request $request)
    {
        $request->validate([
            "num_habitacion" => "required|unique:habitaciones,num_habitacion",
            "id_tipo_habitacion" => ['required', Rule::exists("tipos_habitacion", 'id')->whereNull("deleted_at")],
            "imagen" => "nullable|image|mimes:jpg,jpeg,png|max:2048",
            "descripcion" => "nullable|string",
            "titulo" => "nullable|string"

        ]);

        // return response()->json([$request->all()]);
        // 2. Extraemos todos los datos (menos el archivo)
        $datosHabitacion = $request->except('imagen');

        if ($request->hasFile('imagen')) {
            // Guarda en storage/app/public/habitaciones
            $path = $request->file('imagen')->store('habitaciones', 'public');

            // Generamos la URL pública y la guardamos en el array
            // Ejemplo: /storage/habitaciones/nombre_generado.jpg
            $datosHabitacion['imagen'] = Storage::url($path);
        }
        $datosHabitacion['id_estado'] = 1;
        $habitacion = Habitaciones::create($datosHabitacion);
        return response()->json([
            'message' => 'Habitación creada con éxito',
        ], 201);
    }


    public function showHabitacion(Habitaciones $habitacion)
    {
        return response()->json(["habitacion" => $habitacion]);
    }



    public function updateHabitacion(UpdateHabitacionRequest $request, Habitaciones $habitacion)
    {
        $habitacion->update($request->validated());
        return response()->json(["message" => "Habitación actualizada"], 200);
    }

    public function destroy(Habitaciones $habitacion)
    {

        $habitacion->delete();

        return response()->json(["message" => "Habitacion Eliminada Correctamente"], 200);
    }
}
