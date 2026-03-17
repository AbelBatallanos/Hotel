

export type ThabitacionData = {
    codigo : string,
    capacidad: string,
    descripcion: string,
    imagen : File | null,
    tipo_habitacion_id: string,
}


export type ThabitacionDataEdit = {
    codigo? : string,
    capacidad?: string,
    imagen? : File | null,
    tipo_habitacion_id?: string,
    
}

export type TiposHabitacionT = {
    id: number,
    nombre: string,
    precio_base : number
}

export type THabitaciones = {
    "id" : string | number,
    "codigo": string,
    "titulo"? : string | null,
    "descripcion": string | null,
    "capacidad": string | number,
    "estado": string,
    "imagen": string,
    "tipo_habitacion": string,
    "precio": string | number,
}