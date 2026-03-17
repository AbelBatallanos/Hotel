import { useEffect, useState } from "react";
import useReserva from "../hook/useReserva"
import ConfirmacionReserva from "../components/ConfirmacionReserva";
import type { TReservaAll, TReservasOcupadas, TReservasPendientes } from "../types";
import { ArrowRightIcon, CalendarIcon, ChevronLeftIcon, UserIcon } from "@heroicons/react/24/solid";
import { useLocation, useNavigate, useParams,  } from "react-router-dom";


export default function ReservacionesPage(){
    const {ObtenerReservasGenerales, reservasGenerales, reservaDetalles, ObtenerDetallesPorIdReserva, EliminarDetalle} = useReserva();
    const [selectedReserva ,setSelectedReserva] = useState<boolean>(false);
    const [activeTab ,setActiveTab] = useState<"Pendientes"| "Ocupados">("Pendientes");
    
    const navigate = useNavigate();
    
    const location = useLocation(); //apunta a la url
    const {id} = useParams(); //ontiene la variable de la url

    useEffect(()=>{
        if(location.pathname.includes("/reservaciones")){
            ObtenerReservasGenerales();

        }else{
            console.log(id)
            ObtenerDetallesPorIdReserva(id);
        }
        console.log(selectedReserva)
    }, [location.pathname])


    const eliminarDetalle = async(idDetalle)=>{
        EliminarDetalle(idDetalle);
    }

    return(
        <>
        { !selectedReserva ? 
            ( <div className="max-w-6xl mx-auto">

                <div className="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
                    <div>
                    <h2 className="text-3xl font-black text-slate-900">Módulo de Recepciones</h2>
                    <p className="text-slate-500 mt-1">Gestión administrativa de ingresos y ocupación en tiempo real.</p>
                    </div>
                    <div className="flex items-center bg-white p-1 rounded-2xl shadow-sm border border-slate-200">
                    <button 
                        onClick={() => setActiveTab('Pendientes')}
                        className={`px-6 py-2.5 rounded-xl text-sm font-bold transition-all ${activeTab === 'Pendientes' ? 'bg-amber-500 text-white shadow-lg shadow-amber-200' : 'text-slate-400 hover:bg-slate-50'}`}
                    >
                        Pendientes ({reservasGenerales.Pendientes?.length})
                    </button>
                    <button 
                        onClick={() => setActiveTab('Ocupados')}
                        className={`px-6 py-2.5 rounded-xl text-sm font-bold transition-all ${activeTab === 'Ocupados' ? 'bg-blue-600 text-white shadow-lg shadow-blue-200' : 'text-slate-400 hover:bg-slate-50'}`}
                    >
                        Ocupadas ({reservasGenerales.Ocupados?.length})
                    </button>
                    </div>
                </div>

                <div className="grid grid-cols-1 gap-4">
                    {reservasGenerales[activeTab]?.map((reserva) => (                        
                        <div 
                        key={reserva.id}
                        onClick={() => {
                            if(activeTab === 'Pendientes') {
                                setSelectedReserva(true);
                                navigate(`/reservacion/${reserva.id}/confirmacion`, {replace: true});
                            }
                           }}
                        className={`bg-white border rounded-3xl p-6 flex flex-col md:flex-row items-center gap-6 transition-all group ${activeTab === 'Pendientes' ? 'hover:border-amber-300 cursor-pointer hover:shadow-xl hover:shadow-amber-900/5' : 'border-slate-100 opacity-90'}`}
                        >
                            <div className={`w-14 h-14 rounded-2xl flex items-center justify-center shrink-0 ${activeTab === 'Pendientes' ? 'bg-amber-50 text-amber-500' : 'bg-blue-50 text-blue-500'}`}>
                                <CalendarIcon className="w-7 h-7" />
                            </div>

                            <div className="flex-1 text-center md:text-left">
                                <div className="flex flex-col md:flex-row items-center gap-3 mb-1">
                                <h3 className="font-black text-slate-800 text-lg">Reserva #{reserva.id}</h3>
                                <span className={`text-[10px] font-bold uppercase px-2 py-0.5 rounded-md ${activeTab === 'Pendientes' ? 'bg-amber-100 text-amber-700' : 'bg-blue-100 text-blue-700'}`}>
                                    {reserva.estado}
                                </span>
                                </div>
                                <div className="flex items-center justify-center md:justify-start gap-4 text-sm text-slate-500">
                                <span className="flex items-center gap-1.5 font-medium"><UserIcon className="w-4 h-4" /> {reserva.usuario.name}</span>
                                <span className="w-1 h-1 bg-slate-300 rounded-full"></span>
                                <span className="font-mono">{reserva.fecha_ini} <ArrowRightIcon className="inline w-3 h-3 mx-1" /> {reserva.fecha_fin}</span>
                                </div>
                            </div>

                            <div className="flex items-center gap-8 px-8 md:border-l border-slate-100">
                                <div className="text-center">
                                <p className="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Habitaciones</p>
                                <p className="font-black text-slate-800 text-xl">{reserva.estado === "Ocupada"? reserva.detalles.length : reserva.total_habitaciones}</p>
                                </div>
                                <div className="text-right">
                                <p className="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Monto Total</p>
                                <p className={`font-black text-2xl ${activeTab === 'Pendientes' ? 'text-amber-600' : 'text-blue-600'}`}>${reserva.total.toFixed(2)}</p>
                                </div>
                            </div>

                            { activeTab === 'Ocupados' && (
                                <div className="bg-slate-50 p-3 rounded-2xl text-slate-300 group-hover:bg-blue-600 group-hover:text-white transition-all">
                                <ChevronLeftIcon className="w-5 h-5 rotate-180" />
                                </div>
                            )}
                        </div>
                        
                    ))}
                </div>

            </div>
        ) : 
            (reservaDetalles.usuario && <ConfirmacionReserva reservaDetalles={reservaDetalles} setSelectedReserva={setSelectedReserva} EliminarDetalle={eliminarDetalle}/>)
        }

            
        </>
    )
}