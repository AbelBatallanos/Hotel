<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
<<<<<<< HEAD
=======
use App\Http\Requests\Habitacion\StoreHabitacionRequest;
>>>>>>> 0dcead6 (Implementacion de services correspondiente a las entidades, implementacion de scopes, mutadores y accessors en los modelos)
use App\Http\Requests\Habitacion\UpdateHabitacionRequest;
use App\Http\Resources\HabitacionResource;
use App\Models\Habitaciones;
use App\Services\HabitacionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use SebastianBergmann\CodeCoverage\Test\Target\Function_;

class HabitacionController extends Controller
{
    protected $habitacionService;

    // Inyectamos el servicio en el constructor
    public function __construct(HabitacionService $habitacionService)
    {
        $this->habitacionService = $habitacionService;
    }

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
<<<<<<< HEAD
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
=======
        $habitaciones_disponibles = Habitaciones::conDetalles()
                                                ->disponibles()
                                                ->orderBy("id", "DESC")
                                                ->get();
        return response()->json([
            "estado" => 200,
            "habitaciones_disponibles" => HabitacionResource::collection($habitaciones_disponibles)
        ], 200);
    }

    public function storehabitacion(StoreHabitacionRequest $request)
    {
        $datos = $request->validated();

        $this->habitacionService->crearHabitacion($datos, $request->file("imagen"));
>>>>>>> 0dcead6 (Implementacion de services correspondiente a las entidades, implementacion de scopes, mutadores y accessors en los modelos)

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
<<<<<<< HEAD
        $habitacion->update($request->validated());
        return response()->json(["message" => "Habitación actualizada"], 200);
    }

    public function destroy(Habitaciones $habitacion)
    {

        $habitacion->delete();

        return response()->json(["message" => "Habitacion Eliminada Correctamente"], 200);
    }
=======
        $datos = $request->validated();
        // dd($datos);
        $this->habitacionService->updateHabitacion($habitacion, $datos, $request->file("imagen"));
        
        return response()->json(["message"=>"Datos actualizados correctamente..!!"], 200);
    
    }

    public function destroy($id)
    {
        try{
            $habitacion = Habitaciones::findOrFail($id); 
            $habitacion->delete();
    
            return response()->json(["message" => "Habitacion Eliminada Correctamente"], 200);

        }catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                "message" => "La habitación que intentas eliminar no existe."
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                "message" => "Ocurrió un error inesperado al intentar eliminar la habitación."
            ], 500);
        }
    }
>>>>>>> 0dcead6 (Implementacion de services correspondiente a las entidades, implementacion de scopes, mutadores y accessors en los modelos)
}
