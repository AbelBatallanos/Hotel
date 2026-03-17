import type { THabitaciones } from "../../Habitaciones/types"




export type TReservas = {
    id: number,
    detalles : Detalles[],
    fecha_ini : string ,
    fecha_fin : string,
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


interface TUsuario {
  name: string;
  email: string;
}

export type TReservaConfirmacion = TReservas & {
    usuario : TUsuario
}

export type TReservasOcupadas = Omit<TReservas, "estado"> & {
    usuario : TUsuario,
    estado : "Ocupada"
}
export type TReservasPendientes = Omit<TReservas, "detalles"| "estado"> & {
    total_habitaciones : number | string,
    usuario : TUsuario,
    estado: "Pendiente"
} 
// interface THabitacion {
//   id: number;
//   codigo: string;
//   descripcion: string | null;
//   capacidad: number;
//   estado: string;
//   imagen: string;
//   precio: number;
//   tipo_habitacion: string;
// }

// interface TDetalle {
//   estado: string;
//   habitacion: THabitacion;
//   subtotal: number;
// }

export interface TReservaAll {
  id: number;
  fecha_ini: string;
  fecha_fin: string;
  estado: string;
  total: number;
  usuario: TUsuario;
  detalles: Detalles[];
}
