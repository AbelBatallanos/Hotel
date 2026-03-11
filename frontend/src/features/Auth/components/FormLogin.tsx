
import { useState, type FormEvent } from "react";
import {InputText} from "../../../components/InputText";
import {LabelsInput} from "../../../components/LabelsInput";
import {PrimaryButton} from "../../../components/PrimaryButton";
// import type { TListRols, TRegistro } from "../types";
import type { ResponseServidorErrors } from "../../../types";
import {EyeIcon, EyeSlashIcon} from '@heroicons/react/24/solid'

interface IFormRegister {
    handleChange: (data : React.ChangeEvent<HTMLInputElement>)=> void; 
    handleForm : (ev : FormEvent<HTMLFormElement>)=> void;
    msgError: ResponseServidorErrors["messageError"];
}



export default function FormLogin({  handleChange, handleForm, msgError}: IFormRegister){
    const [shoPassword, setshoPassword] = useState(false);
    return(
        <>
        <div className="bg-slate-600 h-svh flex items-center p-5">
            <div className=" bg-slate-200 w-2/6 mx-auto p-8 rounded-xl">
                <h2 className="text-center text-3xl mb-5 text-orange-600 font-bold">Iniciar Sesión</h2>
                <form className="" onSubmit={handleForm}>
                
                    <div className="flex flex-col space-y-4">
                        <div>
                            <LabelsInput content="Correo:" forname="email"/>
                            <InputText type="text" name="email" id="email" placeholder="Ej: correo@correo.com" requireddata={true} onChange={handleChange}/>
                        </div>
                        <div>
                            
                            <LabelsInput content="Contraseña:" forname="password"/>
                            <div className="w-full relative">
                                <InputText type={`${shoPassword ? 'text':'password'}`} name="password" id="password" placeholder="Ej: 123456" requireddata={true} onChange={handleChange}/>
                                <div className="absolute right-2 top-1 transition-all" onClick={()=> {setshoPassword(!shoPassword)}}>
                                    {shoPassword ? <EyeIcon className="size-6"/>: <EyeSlashIcon className="size-6"/>}
                                </div>
                            </div>
                        </div>

                    </div>
                <PrimaryButton content="iniciar Sesión" bgButton="bg-orange-600" textColorBtn="text-white"/>

                {msgError && (<p className="bg-red-500 p-2 text-xl text-white font-bold text-center mt-5 rounded-xl">{msgError}</p>)}
                </form>
            </div>
        </div>
        </>
    );
}