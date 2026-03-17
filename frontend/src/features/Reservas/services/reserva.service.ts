import api from "../../../api/axios"
import type { TReservacion } from "../../../types";


export const getAllMisReservasApi = async()=>{
    return await api.get("/myreservas");
}


export const CrearReservaApi = async(reserva:TReservacion )=>{
    return await api.post("/reservacion", reserva);
}


export const getAllReservacionesApi = async()=>{
    return await api.get("/reservaciones");
}

export const getDetallesPorIdReservaApi = async(idReserva:string)=>{
    return await api.get(`/reserva/${idReserva}/detalles`);
}

export const deleteDetallePorIdDetalle = async(idDetalle)=>{
    return await api.delete(`/detalle/${idDetalle}`);
}

