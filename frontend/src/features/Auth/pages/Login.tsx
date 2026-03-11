import { useEffect, useState,   } from "react";
import type { TLogin } from "../types";
import FormLogin from "../components/FormLogin";
import useAuth from "../hooks/useAuth";
import { useNavigate } from "react-router-dom";




export default function Login(){
    const [usuarioLogin, setUsuarioLogin] = useState<TLogin>({email:"", password: ""});
    const {iniciarSesion, responseServer} = useAuth();
    const navigate = useNavigate();


    const handleChange = (data : React.ChangeEvent<HTMLInputElement>)=>{
        setUsuarioLogin({...usuarioLogin, [data.target.name] : data.target.value});
    }

    const handleForm = async (ev : React.FormEvent<HTMLFormElement>)=>{
        ev.preventDefault();
        const r = await iniciarSesion(usuarioLogin);
        if(r) setUsuarioLogin({email:"", password: ""});
    }

    useEffect(()=>{
        if(responseServer.msg != "" && responseServer.success){
            
            navigate("/habitaciones", {replace: true})
        }
    }, [responseServer]);

    return(
        <>
            <FormLogin handleChange={handleChange} handleForm={handleForm} msgError={responseServer.messageError}/>
    
        </>
    );
}