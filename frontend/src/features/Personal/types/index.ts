


export type TPersonal = {
    id: string,
    name: string, 
    email: string,
    rol: string,
}

export type TRegistroPersonal = Omit<TPersonal, "id">