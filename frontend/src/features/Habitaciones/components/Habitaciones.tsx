import { NavLink } from "react-router-dom"
import type { THabitaciones } from "../types"
import { CheckCircleIcon, CurrencyDollarIcon, HashtagIcon, PencilSquareIcon, TagIcon, UsersIcon, XCircleIcon } from "@heroicons/react/24/solid";
import useAppStore from "../../../store/appStore";
import { urlApi, urlImage } from "../../../api/axios"; 
interface IHabitaciones {
    HabitacionesData : THabitaciones[];
    agregarHabitacion: (habitacion: THabitaciones)=>void;
    usuario: {email:string, rol:string, name:string};
}


export default function Habitaciones({HabitacionesData, agregarHabitacion, usuario}: IHabitaciones){
    
    const {habitacionesList, existHabitacion , eliminarHabitacion} = useAppStore();
     // Usamos los datos pasados por props o los de ejemplo si no hay ninguno
    // const dataToShow = HabitacionesData && HabitacionesData.length > 0 ? HabitacionesData : mockHabitaciones;
    const dataToShow = HabitacionesData;

    // Simulación de rol para la vista previa (puedes cambiarlo a 'admin' para ver el botón de editar)


    return(
        <>
        <div className="p-4 md:p-8 bg-slate-50 min-h-screen">
            {/* Encabezado Principal */}
            <div className="mb-12 text-center max-w-2xl mx-auto">
                <span className="text-emerald-600 font-bold tracking-widest uppercase text-sm">Experiencia Exclusiva</span>
                <h1 className="text-4xl md:text-5xl font-black text-slate-900 mt-2 mb-4 tracking-tight">
                    Encuentre su <span className="text-emerald-600 underline decoration-emerald-200">Refugio Ideal</span>
                </h1>
                <p className="text-slate-500 text-lg leading-relaxed">
                    Cada habitación ha sido diseñada meticulosamente para ofrecer una estancia de ensueño con los más altos estándares de calidad.
                </p>
            </div>

            {/* Listado de Habitaciones */}
            <section className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                {dataToShow.map((hab) => (
                    <article 
                        key={hab.id} 
                        className="group bg-white rounded-[2.5rem] overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-500 border border-slate-100 flex flex-col h-full"
                    >
                        {/* Contenedor de Imagen */}
                        <div className="relative h-72 overflow-hidden">
                            <img 
                                src={urlImage+hab.imagen} 
                                alt={`image ${hab.titulo}`}
                                className="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110"
                            />
                            
                            {/* Overlay Degradado inferior para legibilidad */}
                            <div className="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>

                            {/* Badge de Estado */}
                            <div className="absolute top-6 left-6">
                                <span className={`flex items-center gap-1.5 px-4 py-1.5 rounded-full text-[10px] font-semibold uppercase tracking-tighter backdrop-blur-md shadow-lg ${
                                    hab?.estado.toLowerCase() === 'disponible' 
                                    ? "bg-emerald-600 text-white" 
                                    : "bg-amber-500 text-white"
                                }`}>
                                    {hab.estado.toLowerCase() === 'disponible' ? (
                                        <CheckCircleIcon className="size-4" />
                                    ) : (
                                        <XCircleIcon className="size-4" />
                                    )}
                                    {hab.estado} 
                                </span>
                            </div>

                            {/* Botón Editar (Solo Admin) */}
                            {usuario.rol === "admin" ? (
                                <NavLink 
                                    to={`/habitaciones/${hab.id}/editar`}
                                    className="absolute top-6 right-6 bg-white p-2.5 rounded-2xl text-slate-700 hover:bg-emerald-600 hover:text-white transition-all duration-300 shadow-xl"
                                >
                                    <PencilSquareIcon className="size-5" />
                                </NavLink>
                            ): ""}

                            {/* Precio sobre la imagen */}
                            <div className="absolute bottom-6 right-6 bg-white/95 backdrop-blur-sm px-4 py-2 rounded-2xl shadow-xl border border-white/20">
                                <p className="text-[10px] font-bold text-slate-400 uppercase leading-none">Precio por noche</p>
                                <p className="text-xl font-black text-emerald-600 leading-none mt-1">
                                    ${hab.precio}
                                </p>
                            </div>

                            {/* Tipo de Habitación */}
                            <div className="absolute bottom-6 left-6 flex items-center gap-2 text-white/90">
                                <TagIcon className="size-4 text-emerald-400" />
                                <span className="text-xs font-bold tracking-wide uppercase">{hab.tipo_habitacion}</span>
                            </div>
                        </div>

                        {/* Contenido Detallado */}
                        <div className="p-8 flex flex-col flex-1">
                            <div className="flex justify-between items-start mb-4">
                                <h3 className="text-2xl font-extrabold text-slate-800 leading-tight">
                                    {hab.titulo}
                                </h3>
                                <div className="hidden sm:flex items-center gap-1 text-slate-400 font-mono text-xs bg-slate-50 px-2 py-1 rounded-lg border border-slate-100">
                                    <HashtagIcon className="size-3" />
                                    {hab.codigo}
                                </div>
                            </div>

                            <p className="text-slate-500 text-sm leading-relaxed mb-8 line-clamp-3">
                                {hab.descripcion?? "Sin Descripción"}
                            </p>

                            {/* Características Rápidas */}
                            <div className="flex items-center gap-6 mb-8 py-4 border-y border-slate-50">
                                <div className="flex items-center gap-2">
                                    <div className="bg-emerald-50 p-2 rounded-lg">
                                        <UsersIcon className="size-4 text-emerald-600" />
                                    </div>
                                    <span className="text-xs font-bold text-slate-700">{hab.capacidad} Huéspedes</span>
                                </div>
                                <div className="flex items-center gap-2">
                                    <div className="bg-slate-50 p-2 rounded-lg">
                                        <CurrencyDollarIcon className="size-4 text-slate-600" />
                                    </div>
                                    <span className="text-xs font-bold text-slate-700">All-Inclusive</span>
                                </div>
                            </div>

                            {/* Botón de Reservar */}
                            <div className="mt-auto">
                                {!existHabitacion(hab.id)? (
                                <button type="button" onClick={()=>{agregarHabitacion(hab)}}
                                    className={`w-full group/btn flex justify-center items-center py-4 rounded-2xl font-black uppercase text-xs tracking-widest transition-all duration-300 ${
 
                                         "bg-slate-900 text-white hover:bg-emerald-600 shadow-xl shadow-slate-200 hover:shadow-emerald-200"
                                  
                                    }`}
                                >
                                   
                                    {hab.estado.toLowerCase() === 'disponible' ? (
                                        <span className="flex items-center gap-2" >
                                            Reservar Habitación
                                            <svg className="size-4 transition-transform group-hover/btn:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>
                                        </span>
                                    ) : "No Disponible Actualmente"}
                                </button>)  :
                                 (<button type="button" onClick={()=>{eliminarHabitacion(hab.id)}}
                                    className={`w-full group/btn flex justify-center items-center py-4 rounded-2xl font-black uppercase text-xs tracking-widest transition-all duration-300 bg-slate-900 text-white hover:bg-red-500 shadow-xl shadow-slate-200 hover:shadow-red-200`}
                                >
                                        <span className="flex items-center gap-2" >
                                            Retirar Habitación
                                            <svg className="size-4 transition-transform group-hover/btn:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>
                                        </span>
                                </button>)   }
                            </div>
                        </div>
                    </article>
                ))}
            </section>
        </div>
    );

        </>
    )
}