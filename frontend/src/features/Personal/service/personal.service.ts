import api from "../../../api/axios";
import type { TRegistroPersonal } from "../../../types";


export const getAllPersonalApi = async()=>{
    return await api.get("/personal");
}


export const crearPersonalApi = async(personal: TRegistroPersonal) => {
    return await api.post("/personal", personal)
} 