import { useState } from "react";
import type { TReservacion } from "../../../types";

import {CrearReservaApi, deleteDetallePorIdDetalle, getAllMisReservasApi, getAllReservacionesApi,  getDetallesPorIdReservaApi} from "../services/reserva.service"

import type { ErrorHabitacionesOcupadasT, TReservaConfirmacion, TReservas, TReservasOcupadas, TReservasPendientes } from "../types";

interface IreservasGenerales {
    Pendientes: TReservasPendientes[] , Ocupados: TReservasOcupadas[],
}

export default function useReserva(){
    const [Reservaciones, setReservaciones] = useState( [] as TReservas[]);
    const [ErrorHabitacionesOcupadas, setErrorHabitacionesOcupadas] = useState<ErrorHabitacionesOcupadasT>({} as ErrorHabitacionesOcupadasT);
    const [reservasGenerales, setReservasGenerales] = useState<IreservasGenerales>({} as IreservasGenerales);
    const [reservaDetalles, setReservaDetalles] = useState<TReservaConfirmacion>({} as TReservaConfirmacion);


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

    const EliminarDetalle = async(idDetalle)=>{
        try {
            // const r = await deleteDetallePorIdDetalle(idDetalle);
            console.log(idDetalle);
        } catch (error:any) {
            console.log(error)
        }
    }


    const ObtenerReservasGenerales = async()=> {
        try {
            const r = await getAllReservacionesApi();
            console.log(r.data);
            setReservasGenerales(r.data);
        } catch (error: any) {
            console.log(error)
        }
    }

    const ObtenerDetallesPorIdReserva = async(idReserva: string)=>{
        try {
            console.log(idReserva + " ID")
            const r = await getDetallesPorIdReservaApi(idReserva);
            console.log(r.data)
            setReservaDetalles(r.data.reserva);
        } catch (error: any) {
            console.log(error)
        }
    }

    return{
        Reservaciones,
        reservaDetalles,
        reservasGenerales,
        ErrorHabitacionesOcupadas,
        CrearReserva,
        ObtenerMisReservaciones,
        ObtenerReservasGenerales,
        ObtenerDetallesPorIdReserva,
        EliminarDetalle,
    }
}