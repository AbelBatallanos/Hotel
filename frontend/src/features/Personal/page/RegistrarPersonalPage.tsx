import React, { useEffect, useState } from "react";
import usePersonal from "../hooks/usePersonal"
import type { TRegistroPersonal } from "../types";
import RegistroPersonal from "../components/FormRegistro";
import { useNavigate } from "react-router-dom";


export default function RegistrarPersonalPage(){
    const {CrearPersonal, ResponseServer} = usePersonal();
    const [DataUsuario, setDataUsuario] = useState<TRegistroPersonal>({email: "", name: "", rol: ""});
    const navigate = useNavigate();

    useEffect(()=>{
        console.log(DataUsuario)
    }, [DataUsuario])
    const cancelarRegistrto = ()=>{
        setDataUsuario({email: "", name: "", rol: ""})  ;
        navigate("/personal", {replace: true})
    }

    const handleChange = (data: React.ChangeEvent<HTMLInputElement | HTMLSelectElement>)=>{
        setDataUsuario({...DataUsuario, [data.target.name]: data.target.value})
    }


    const handleSubmit= (ev: React.FormEvent<HTMLFormElement>)=>{
        ev.preventDefault();
        CrearPersonal(DataUsuario);
    }

    return(
        <>
            <RegistroPersonal cancelarRegistrto={cancelarRegistrto}
             handledChange={handleChange}
             handleSubmit={handleSubmit}
            msg={ResponseServer.msg}
            />
        </>
    )

}