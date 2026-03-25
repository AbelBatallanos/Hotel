<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\HabitacionResource;
use App\Models\Habitaciones;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
        $habitaciones_disponibles = Habitaciones::where("estado_id", 1)->orderBy("id", "DESC")->get();

        return response()->json([
            "estado" => 200,
            "habitaciones_disponibles" => HabitacionResource::collection($habitaciones_disponibles)
        ], 200);
    }

    public function storehabitacion(Request $request)
    {
        // $request->validate([ antiguo
        //     "codigo" => "required|unique:habitaciones,codigo",
        //     "capacidad" => "required|integer",
        //     "descripcion" => "required|string",
        //     "tipo_habitacion_id" => "required|exists:tipos_habitacion,id",
        //     "imagen" => "nullable|image|mimes:jpg,jpeg,png|max:2048"
        // ]);
        $request->validate([
            "num_habitacion" => "required|unique:habitaciones,codigo",
            "capacidad" => "required|integer",
            "descripcion" => "required|string",
            "id_tipo_habitacion" => "required|exists:tipos_habitacion,id",
            "imagen" => "nullable|image|mimes:jpg,jpeg,png|max:2048"
        ]);

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



    public function updateHabitacion(Request $request, Habitaciones $habitacion)
    {
        // $request->validate([ antiguo
        //     "codigo" => "sometimes|string",
        //     "capacidad" => "sometimes|integer",
        //     "tipo_habitacion_id" => "sometimes|exist:tipos_habitacion,id",
        //     "estado_id" => "sometimes|exist:estado,id"
        // ]);
        $request->validate([
            "codigo" => "sometimes|string",
            "capacidad" => "sometimes|integer",
            "tipo_habitacion_id" => "sometimes|exist:tipos_habitacion,id",
            "estado_id" => "sometimes|exist:estado,id"
        ]);

        try {
            $habDB = Habitaciones::find($habitacion->id)->first();
            if (!$habDB) {
                return response()->json([
                    "message-error" => "No se hencontro la habitación",
                    "estado"  => 404,
                ]);
            }

            if ($request->codigo) $habDB->update(["num_habitacion" => $request->codigo]);
            if ($request->capacidad) $habDB->update(["capacidad" => $request->capacidad]);
            if ($request->tipo_habitacion_id) $habDB->update(["id_tipo_habitacion" => $request->tipo_habitacion_id]);
            if ($request->estado_id) $habDB->update(["id_estado" => $request->estado_id]);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function destroy(Habitaciones $habitacion)
    {

        $habitacion->delete();

        return response()->json(["message" => "Habitacion Eliminada Correctamente", "estado" => 200], 200);
    }
}
