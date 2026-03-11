
import type { FormEvent } from "react";
import {InputText} from "../../../components/InputText";
import {LabelsInput} from "../../../components/LabelsInput";
import {PrimaryButton} from "../../../components/PrimaryButton";
import type { TListRols, TRegistro } from "../types";
import { BuildingOfficeIcon } from "@heroicons/react/24/solid";


interface IFormRegister {
    usuario: TRegistro;
    ListRols : TListRols; 
    handleChange: (data : React.ChangeEvent<HTMLInputElement>)=> void; 
    handleForm : (ev : FormEvent<HTMLFormElement>)=> void;
    
}



export default function FormRegister({ usuario, ListRols, handleChange, handleForm}: IFormRegister){
    return(
        <div className="relative min-h-screen flex items-center justify-center p-5 bg-slate-900">
            {/* Imagen de fondo premium con overlay oscuro */}
            <div 
                className="absolute inset-0 z-0 bg-cover bg-center bg-no-repeat"
                style={{ backgroundImage: "url('https://images.unsplash.com/photo-1542314831-c6a4d14d8c85?q=80&w=2070&auto=format&fit=crop')" }}
            >
                <div className="absolute inset-0 bg-slate-900/75 backdrop-blur-[2px]"></div>
            </div>

            {/* Tarjeta del formulario (Glassmorphism / Limpia) */}
            <div className="relative z-10 bg-white/95 backdrop-blur-xl w-full max-w-lg p-10 rounded-[2rem] shadow-2xl border border-white/20">
                
                {/* Cabecera del formulario */}
                <div className="flex flex-col items-center mb-8">
                    <div className="bg-emerald-100 p-3 rounded-2xl text-emerald-600 mb-4 shadow-sm border border-emerald-200">
                        <BuildingOfficeIcon className="size-8" />
                    </div>
                    <h2 className="text-center text-3xl font-extrabold text-slate-800">
                        Crear <span className="text-emerald-600">Cuenta</span>
                    </h2>
                    <p className="text-slate-500 text-sm mt-2 font-medium">Únete a la experiencia de Hotel Moron</p>
                </div>

                <form className="space-y-5" onSubmit={handleForm}>
                    
                    <div className="space-y-5">
                        <div className="flex flex-col gap-1.5">
                            <LabelsInput content="Nombre:" forname="name"/>
                            <InputText type="text" name="name" id="name" placeholder="Ej: Alex" requireddata={true} onChange={handleChange} />
                        </div>
                        
                        <div className="flex flex-col gap-1.5">
                            <LabelsInput content="Correo:" forname="email"/>
                            <InputText type="email" name="email" id="email" placeholder="Ej: correo@correo.com" requireddata={true} onChange={handleChange}/>
                        </div>
                        
                        <div className="flex flex-col gap-1.5">
                            <LabelsInput content="Contraseña:" forname="password"/>
                            <InputText type="password" name="password" id="password" placeholder="••••••••" requireddata={true} onChange={handleChange}/>
                        </div>
                        
                        <div className="flex flex-col gap-1.5">
                            <LabelsInput content="Roles:" forname="rol_id"/>
                            {/* Diseño mejorado para el select nativo */}
                            <div className="relative">
                                <select 
                                    value={usuario.rol_id} 
                                    name="rol_id" 
                                    id="rol_id" 
                                    className="w-full bg-slate-50 border border-slate-200 text-slate-700 text-sm rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 block p-3.5 transition-all outline-none appearance-none shadow-sm" 
                                    onChange={handleChange}
                                >
                                    <option value={0} className="text-slate-400">---- Seleccionar Rol ----</option>
                                    {ListRols.map( rol => (
                                        <option key={rol.id} value={rol.id}> {rol.nombre}</option>
                                    ))}
                                </select>
                                {/* Pequeña flecha personalizada para el select */}
                                <div className="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-500">
                                    <svg className="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div className="pt-4">
                        <PrimaryButton 
                            content="Registrarse" 
                            bgButton="bg-emerald-600 hover:bg-emerald-500 transition-all duration-300 w-full rounded-xl py-3.5 shadow-lg shadow-emerald-500/30" 
                            textColorBtn="text-white font-bold text-lg"
                        />
                    </div>
                </form>
            </div>
        </div>
    );
}