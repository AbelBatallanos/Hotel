import type { THabitaciones } from "../../Habitaciones/types"




export type TReservas = {
    id: number,
    detalles : Detalles[],
    fecha_ini : Date,
    fecha_fin : Date,
    total: number,
    estado: string,
}

type Detalles = {
    estado : string,
    subtotal: number,
    habitacion: THabitaciones,
}


export type ErrorHabitacionesOcupadasT = {
    error:  boolean,
    messageError: string,
    ocupadas : {id: string, codigo: string}[],
}