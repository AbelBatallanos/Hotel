
import { useEffect, useState } from "react";
import {getAllPersonalApi, crearPersonalApi} from "../service/personal.service";
import type { TPersonal, TRegistroPersonal,  } from "../types";
import type { ResponseServidorErrors } from "../../../types";

export default function usePersonal(){
    const [PersonalList, setPersonal] = useState<TPersonal[]>([]);
    const [ResponseServer, setResponseServer] = useState<ResponseServidorErrors>({success:false, messageError: "", msg: ""}); 
    

    useEffect(()=>{
        if(ResponseServer.msg !=""){
             const timer = setTimeout(() => {
              setResponseServer({ success:false, messageError:"", msg:"" });
            }, 3000); // 3 segundos
        
            return () => clearTimeout(timer);
        }
    },[ResponseServer.msg])

    const ObtenerPersonal = async()=>{
        try {
           const response = await getAllPersonalApi();
           setPersonal(response.data.personal);

        } catch (error) {
            console.log(error)
        }
    }
    const CrearPersonal = async(personalData: TRegistroPersonal)=>{
        try {
            const response = await crearPersonalApi(personalData);
            setResponseServer({success:true, msg:response.data.message, messageError:""});
        } catch (error:any) {
            console.log(error)
            // setResponseServer({success:true, msg:response.data.message, messageError:""});
        }
        
    }
    return{
        ResponseServer,
        PersonalList,
        ObtenerPersonal,
        CrearPersonal,
    }
}