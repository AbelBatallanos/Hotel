


export type TRegistro = {
    name : string,
    email : string,
    password : string,
    rol_id : number,
}

export type TLogin = Pick<TRegistro, "email" | "password">

type TRols = {
    id: number,
    nombre: string
}
export type TListRols = [TRols]