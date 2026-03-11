import api from "../../../api/axios"

import type{ TLogin, TRegistro } from "../types"

export const registroUsuario = async(usuarioData : TRegistro) => {
    return await api.post("/register", usuarioData);
}

export const loginUsuario = async(usuarioData : TLogin) => {
    return await api.post("/login", usuarioData);
}

export const logoutUsuario = async()=>{
    return await api.post("/logout");
}
