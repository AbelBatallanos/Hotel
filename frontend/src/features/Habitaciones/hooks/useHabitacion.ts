import { useState } from "react";
import {ObtenerTiposHabitacionApi, CrearHabitacionApi, EditarHabitacionApi, getHabitacionesApi} from "../services/habitaciones.service";
import type { ThabitacionData, THabitaciones, TiposHabitacionT } from "../types";
import type { ResponseServidorErrors } from "../../../types";



export default function useHabitacion(){
    const [ListTiposHabitaciones, setListTiposHabitaciones] = useState([] as TiposHabitacionT[]);
    const [ResponseServer, setResponseServer] = useState<ResponseServidorErrors>({success:false, messageError: "", msg: ""}); 
    const [HabitacionesData, setHabitacionesData] = useState<THabitaciones[]>([]);



    const ObtenerTiposHabitacion = async()=>{
       const resp = await ObtenerTiposHabitacionApi();
       setListTiposHabitaciones(resp.data.data);
    }

    const CrearHabitacion = async(habitacion : ThabitacionData)=> {
        try {
           const response= await CrearHabitacionApi(habitacion);
            console.log(response);
           setResponseServer({success: true, msg: response.data.message});
        } catch (error:any) {
            console.log(error);
            
            // setResponseServer({success:false, msg: "", messageError: error.data})
        }
    }

    const EditarHabitacion = async(habitacion : ThabitacionData)=> {
        try {
            // await EditarHabitacionApi(habitacion);
        } catch (error:any) {
            console.log(error);
        }
    }

    const ObtenerHabitaciones = async()=>{
        try {
            const habitaciones = await getHabitacionesApi();
            setHabitacionesData(habitaciones.data.habitaciones_disponibles);
        } catch (error: any) {
               console.log(error);
        }
    }

    return{
        HabitacionesData,
        ResponseServer,
        ListTiposHabitaciones,
        ObtenerTiposHabitacion,
        CrearHabitacion,
        EditarHabitacion,
        ObtenerHabitaciones
    }
}