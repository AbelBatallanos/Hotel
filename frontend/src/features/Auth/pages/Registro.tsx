import { useEffect, useState } from "react";
import type{TRegistro} from "../types";
import FormRegister from "../components/FormRegistro";
// import { registroUsuario } from "../service/auth.service";
import useAuth from "../hooks/useAuth";
import { useNavigate } from "react-router-dom";



const initialUsuario = {name:"", email:"", password: "", rol_id:0};

export default function Registro(){
    const listRols = [ {id: 1, nombre: "admin"},{id: 2, nombre: "recepcionista"},{id: 3, nombre: "cliente"}];
    const [usuario, setUsuario] = useState<TRegistro>(initialUsuario); 
    const {registro, responseServer} = useAuth();
    const navigate = useNavigate();
    
    const handleChange = (data : React.ChangeEvent<HTMLInputElement | HTMLSelectElement>)=>{
        console.log(data.target.value);
        setUsuario({...usuario, [data.target.name]: data.target.value})
    }

    const handleForm = async (ev : React.FormEvent<HTMLFormElement>)=>{
        ev.preventDefault();
        console.log("holaa")
        const r = await registro(usuario);
        if(r) setUsuario(initialUsuario);

    }

    useEffect(()=>{
        if(responseServer.msg != "" && responseServer.success){
            
            navigate("/habitaciones", {replace: true})
        }
    }, [responseServer]);
    

    return(
        <>
        <FormRegister  usuario={usuario} ListRols={listRols} handleChange={handleChange} handleForm={handleForm}/>
        </>
    );
}