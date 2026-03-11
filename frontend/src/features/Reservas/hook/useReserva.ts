import { useState } from "react";
import type { TReservacion } from "../../../types";
import {CrearReservaApi, getAllMisReservasApi} from "../services/reserva.service"
import type { ErrorHabitacionesOcupadasT, TReservas } from "../types";

export default function useReserva(){
    const [Reservaciones, setReservaciones] = useState( [] as TReservas[]);
    const [ErrorHabitacionesOcupadas, setErrorHabitacionesOcupadas] = useState<ErrorHabitacionesOcupadasT>({} as ErrorHabitacionesOcupadasT);


    const ObtenerMisReservaciones = async()=>{
        try {           
            const response = await getAllMisReservasApi();
            setReservaciones(response.data.reservas);
            console.log(response.data.reservas);
        } catch (error) {
            console.log(error)
        }
    }

    const CrearReserva = async(reserva: TReservacion)=>{
        try {
            const r = await CrearReservaApi(reserva);
            console.log(r.data);
            return true;
        } catch (error:any) {
            if(error.response){
                if(error.response.status === 409){
                    setErrorHabitacionesOcupadas(error.response.data)
                }
              console.log("Status:", error.response.status);
              console.log("Datos del servidor:", error.response.data);
            }else{
                      console.log("Error inesperado:", error.message);
            }
            // if(error)
            return false
        }
    }

    return{
        Reservaciones,
        ErrorHabitacionesOcupadas,
        CrearReserva,
        ObtenerMisReservaciones,
    }
}