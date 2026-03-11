import api from "../../../api/axios";
import type{ ThabitacionData } from "../types";


export const ObtenerTiposHabitacionApi = async()=>{
    return await api.get("/tiposhabitacion");
}


export const CrearHabitacionApi = async(habitacion : ThabitacionData ) => {
    return await api.post("/habitacion", habitacion,{
        headers: {
            "Content-Type": "multipart/form-data",
        }
    });
}

export const EditarHabitacionApi = async(idHabitacion:string , habitacionData: ThabitacionData)=>{
    // return await api.put(`/habitacion/${}`);
}

export const getHabitacionesApi = async()=>{
    return await api.get("/habitaciones");
}