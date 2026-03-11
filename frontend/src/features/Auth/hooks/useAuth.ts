import { useEffect, useState } from "react";
import { loginUsuario, registroUsuario, logoutUsuario } from "../service/auth.service";
import type { TLogin, TRegistro } from "../types";
import useLocalStorage from "../../../hooks/useLocalstorage";
import type{ResponseServidorErrors} from "../../../types";




export default function useAuth(){
    const [loading, setLoading] = useState(false);
    const [responseServer, setResponseServer] = useState<ResponseServidorErrors>({messageError : "", msg: "", success: false});
    const {getDataLocalStorage, saveDataLocalStorage, removeDataLocalStorage} = useLocalStorage();


    useEffect(()=>{
        if(responseServer.msg != "" || responseServer.messageError != ""){
            setTimeout(()=>{
            setResponseServer({messageError : "", msg: "", success: false});
        }, 5000)
        }
        
    }, [responseServer])




    const registro = async(credencial : TRegistro)=> {
        try {
            setLoading(true)
            console.log(credencial)
            const response = await registroUsuario(credencial);
            console.log(response);
            setResponseServer({msg: response.data, success: true});
            saveDataLocalStorage(response.data.token, "token");
            saveDataLocalStorage(response.data.user, "usuario");
            return true;
        } catch (error:any) {
            console.log(error)

            if(error.response){
                if(error.response.status === 400){
                    console.log(error.response.data.messageError);
                    setResponseServer({messageError: error.response.data.messageError, success : false});
                }
            } 
            return false
        }finally{
            setLoading(false);
        }

    }
    const iniciarSesion = async(credencial: TLogin)=> {
        try {
            setLoading(true);
            const response = await loginUsuario(credencial);
            console.log(response.data.token);
            console.log(response.data.user);
            setResponseServer({msg: response.data, success: true});
            saveDataLocalStorage(response.data.token, "token")
            saveDataLocalStorage(response.data.user, "usuario")
            return true;
            
        } catch (error: any) {
            if(error.response){
                if(error.response.status === 400){
                    console.log(error.response.data.messageError);
                    setResponseServer({messageError: error.response.data.messageError, success: false});
                }
            }
            console.log(error)
            return false
            // console.log("Mensage con error")
        }finally{
            setLoading(false);
        }
    }

    const logout = async()=>{
        try {
            // 1. Llamamos al servicio para avisar al servidor
            await logoutUsuario(); 
        } catch (error) {
            console.error("Error al cerrar sesión en el servidor:", error);
            // Nota: Incluso si el servidor falla, a veces es mejor 
            // forzar el cierre en el cliente.
        } finally {
            // 2. LIMPIEZA OBLIGATORIA EN EL CLIENTE
            
            // Borramos el token del localStorage
            removeDataLocalStorage('token'); 
            
            // Limpiamos el estado del usuario en React (si usas Context o Zustand)
            // setUsuario(null); 
            // setAutenticado(false);
    
            // 3. Redirigir al Login (puedes usar useNavigate de react-router-dom)
            // navigate('/login');
        }
    }
    return {
        loading,
        responseServer, 
        registro,
        iniciarSesion,
        logout
    };
}