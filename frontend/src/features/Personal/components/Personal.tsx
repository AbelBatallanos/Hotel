import {UserPlusIcon, UsersIcon, MagnifyingGlassIcon, EnvelopeIcon, TrashIcon, PencilSquareIcon} from "@heroicons/react/24/solid";
import { NavLink } from "react-router-dom";
import type { TPersonal } from "../types";


interface IPersonal{
    PersonalList :TPersonal[]
}


export default function Personal({PersonalList}: IPersonal){

    return(
        <>
            <div className="max-w-6xl mx-auto animate-in fade-in duration-500">
            {/* Header Listado */}
            <div className="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
              <div>
                <h2 className="text-2xl font-bold text-slate-800 flex items-center gap-2">
                  <UsersIcon className="text-emerald-500 size-6" /> Control de Personal
                </h2>
                <p className="text-slate-500 text-sm">Gestiona los accesos y perfiles de los empleados del hotel.</p>
              </div>
              <div className="flex items-center gap-3">
                <div className="relative">
                  <MagnifyingGlassIcon className="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" />
                  <input 
                    type="text" 
                    placeholder="Buscar por nombre o email..."
                    className="pl-10 pr-4 py-2 bg-white border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 outline-none w-full md:w-72 transition-all shadow-sm"
                  />
                </div>
                <NavLink
                  to={"/personal/nuevo"}
                  className="bg-emerald-500 text-white px-4 py-2 rounded-xl text-sm font-semibold hover:bg-emerald-600 transition-all flex items-center gap-2 shadow-lg shadow-emerald-100"
                >
                  <UserPlusIcon className="w-4 h-4" />
                  Añadir
                </NavLink>
              </div>
            </div>

            {/* Tabla de Personal */}
            <div className="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
              <table className="w-full text-left border-collapse">
                <thead>
                  <tr className="bg-slate-50 border-b border-slate-100">
                    <th className="px-6 py-4 text-xs font-bold text-slate-500 uppercase">ID</th>
                    <th className="px-6 py-4 text-xs font-bold text-slate-500 uppercase">Colaborador</th>
                    <th className="px-6 py-4 text-xs font-bold text-slate-500 uppercase">Email</th>
                    <th className="px-6 py-4 text-xs font-bold text-slate-500 uppercase">Rol</th>
                    <th className="px-6 py-4 text-xs font-bold text-slate-500 uppercase text-right">Acciones</th>
                  </tr>
                </thead>
                <tbody className="divide-y divide-slate-100">
                  {PersonalList.map((person) => (
                    <tr key={person.id} className="hover:bg-slate-50/50 transition-colors group">
                      <td className="px-6 py-4">
                        <span className="font-mono text-xs font-bold text-slate-400 bg-slate-100 px-2 py-1 rounded">
                          #00{person.id}
                        </span>
                      </td>
                      <td className="px-6 py-4">
                        <div className="flex items-center gap-3">
                          <div className="w-8 h-8 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center font-bold text-xs">
                            {person.name.charAt(0)}
                          </div>
                          <span className="font-semibold text-slate-700">{person.name}</span>
                        </div>
                      </td>
                      <td className="px-6 py-4">
                        <div className="flex items-center gap-2 text-slate-500">
                          <EnvelopeIcon className="w-3.5 h-3.5" />
                          <span className="text-sm">{person.email}</span>
                        </div>
                      </td>
                      <td className="px-6 py-4">
                        <span className="text-xs font-medium text-slate-600 px-2.5 py-1 bg-slate-100 rounded-lg">
                          {person.rol}
                        </span>
                      </td>
                     
                      <td className="px-6 py-4 text-right">
                        <div className="flex items-center justify-end gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                          <button className="p-2 text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-all">
                            <PencilSquareIcon className="w-4 h-4" />
                          </button>
                          <button className="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-all">
                            <TrashIcon className="w-4 h-4" />
                          </button>
                        </div>
                      </td>
                    </tr>
                  ))}
                </tbody>
              </table>

              {/* Paginación */}
              <div className="px-6 py-4 bg-slate-50/50 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                <p>Mostrando {PersonalList.length} colaboradores activos</p>
                {/* <div className="flex gap-2">
                  <button className="p-2 bg-white border border-slate-200 rounded-lg hover:text-emerald-500 transition-colors"><ChevronLeft className="w-4 h-4" /></button>
                  <button className="p-2 bg-white border border-slate-200 rounded-lg hover:text-emerald-500 transition-colors"><ChevronRight className="w-4 h-4" /></button>
                </div> */}
              </div>
            </div>
          </div>
        
        </>
    );
}