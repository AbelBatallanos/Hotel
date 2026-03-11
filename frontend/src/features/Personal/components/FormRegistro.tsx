
import {ShieldCheckIcon, UserCircleIcon, UserPlusIcon, EnvelopeIcon, IdentificationIcon} from "@heroicons/react/24/solid";
import type { ResponseServidorErrors } from "../../../types";

interface IRegistroPersonal {
    cancelarRegistrto: ()=> void,
    handledChange: (data: React.ChangeEvent<HTMLInputElement | HTMLSelectElement>)=>void ,
    handleSubmit: (ev: React.FormEvent<HTMLFormElement>)=> void;
     msg : ResponseServidorErrors["msg"];
}


export default function RegistroPersonal({cancelarRegistrto, handledChange, handleSubmit, msg}: IRegistroPersonal){
    
    return(
        <>
        <div className="max-w-3xl mx-auto animate-in slide-in-from-bottom-4 duration-500">
            {/* Header Formulario */}
            <div className="flex items-center gap-4 mb-8">
              <div className="bg-emerald-500 p-3 rounded-2xl shadow-lg shadow-emerald-100">
                <UserPlusIcon className="w-8 h-8 text-white" />
              </div>
              <div>
                <h2 className="text-2xl font-bold text-slate-800">Nuevo Colaborador</h2>
                <p className="text-slate-500 text-sm">Registra la información personal y laboral del nuevo integrante.</p>
              </div>
            </div>

            {/* Form Card */}
            <form onSubmit={handleSubmit} className="bg-white rounded-3xl shadow-sm border border-slate-200 p-8">
              <div className="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                {/* Nombre */}
                <div className="space-y-2">
                  <label className="text-[10px] font-bold text-slate-400 uppercase tracking-widest flex items-center gap-2">
                    <UserCircleIcon className="w-4 h-4" /> Nombre Completo
                  </label>
                  <input 
                    type="text" 
                    name="name"
                    id="name"
                    placeholder="Ej: Daniela Lopez"
                    onChange={handledChange}
                    className="w-full px-4 py-3.5 rounded-2xl border border-slate-200 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none transition-all bg-slate-50/50"
                  />
                </div>

                {/* Email */}
                <div className="space-y-2">
                  <label className="text-[10px] font-bold text-slate-400 uppercase tracking-widest flex items-center gap-2">
                    <EnvelopeIcon className="w-4 h-4" /> Correo Electrónico
                  </label>
                  <input 
                    type="email" 
                    name="email"
                    id="email"
                     onChange={handledChange}
                    placeholder="ejemplo@hotel.com"
                    className="w-full px-4 py-3.5 rounded-2xl border border-slate-200 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none transition-all bg-slate-50/50"
                  />
                </div>
              </div>

              <div className="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                {/* Rol */}
                <div className="space-y-2">
                  <label className="text-[10px] font-bold text-slate-400 uppercase tracking-widest flex items-center gap-2">
                    <ShieldCheckIcon className="w-4 h-4" /> Rol de Usuario
                  </label>
                  <select name="rol" id="rol"  onChange={handledChange} className="w-full px-4 py-3.5 rounded-2xl border border-slate-200 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none bg-slate-50/50 transition-all cursor-pointer" defaultValue={0}>
                    <option value="0" selected disabled>Selecciona un cargo</option>
                    <option value="2">Recepcionista</option>

                  </select>
                </div>

                {/* ID Empleado */}
                <div className="space-y-2">
                  <label className="text-[10px] font-bold text-slate-400 uppercase tracking-widest flex items-center gap-2">
                    <IdentificationIcon className="w-4 h-4" /> ID Identificador
                  </label>
                  <input 
                    type="text" 
                    placeholder="Automático"
                    disabled
                    className="w-full px-4 py-3.5 rounded-2xl border border-slate-200 bg-slate-100 text-slate-400 cursor-not-allowed"
                  />
                </div>
              </div>

              {/* Footer Actions */}
              <div className="flex items-center justify-between pt-8 border-t border-slate-100">
                <button 
                    type="button" 
                    onClick={cancelarRegistrto}
                    className="px-6 py-3 text-slate-400 font-semibold hover:text-slate-600 transition-colors"
                >
                  Cancelar
                </button>
                <button className="px-10 py-3.5 bg-slate-900 text-white rounded-2xl font-bold flex items-center gap-3 shadow-xl shadow-slate-200 hover:bg-emerald-600 hover:shadow-emerald-100 transition-all active:scale-95" type="submit">
                  <UserPlusIcon className="w-5 h-5" />
                  Guardar Registro
                </button>
              </div>
            </form>
            { msg && (<p className="bg-emerald-600 text-center w-2/4 uppercase text-white p-2 rounded-xl font-bold mt-4 mx-auto">{msg}</p>)}
          </div>
        </>
    );

}