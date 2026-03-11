import type { THabitaciones } from "../features/Habitaciones/types";

export type ResponseServidorErrors = {
    success : boolean,
    messageError? : string,    
    msg?: string,
}

export type TinfoUser = {
    email: string,
    name: string,
    rol : string

}

export type TRegistroPersonal = TinfoUser;


export type TReservacion = {
    // fecha_ini: Date,
    // fecha_fin: Date,
    habitaciones:  { id: string }[],
}