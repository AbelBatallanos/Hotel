import { useEffect, useState } from "react";
import useReserva from "../hook/useReserva"
import {MagnifyingGlassIcon, CalendarIcon, ChevronDownIcon, ChevronUpIcon, ArrowLongRightIcon, } from "@heroicons/react/24/outline"
import { BuildingOfficeIcon, CheckCircleIcon, ClockIcon, CreditCardIcon, InformationCircleIcon, UsersIcon } from "@heroicons/react/24/solid";
import { NavLink } from "react-router-dom";
import { urlImage } from "../../../api/axios";


export default function MisReservasPage(){
    const {ObtenerMisReservaciones, Reservaciones} = useReserva();
    const [expandedReserva, setexpandedReserva] = useState<number | null>(null);
    useEffect(()=>{
        ObtenerMisReservaciones();
    },[]);


    const toggleReserva = (id:number)=>{
        setexpandedReserva(expandedReserva === id ? null: id);
    }

    return(
        <div className="min-h-screen bg-[#f1f5f9] flex font-sans">
            <div className="max-w-4xl mx-auto p-10">
                {/* Header Section */}
                <div className="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
                <div>
                    <h2 className="text-3xl font-black text-slate-900 mb-2">Mis Reservaciones</h2>
                    <p className="text-slate-500">Historial de estancias y servicios solicitados.</p>
                </div>
                <div className="flex items-center gap-4">
                    <div className="relative">
                    <MagnifyingGlassIcon className="w-4 h-4 absolute left-4 top-1/2 -translate-y-1/2 text-slate-400" />
                    <input 
                        type="text" 
                        placeholder="Buscar reserva..."
                        className="pl-11 pr-4 py-3 bg-white border-none rounded-2xl text-sm shadow-sm focus:ring-2 focus:ring-blue-500 outline-none w-full md:w-64 transition-all"
                    />
                    </div>
                </div>
                </div>

                {/* Listado de Reservas */}
                <div className="space-y-6">
                {Reservaciones != undefined && Reservaciones.map((reserva) => (
                    <div key={reserva.id} className="bg-white rounded-[2rem] shadow-sm border border-slate-200 overflow-hidden transition-all hover:shadow-md">
                    {/* Cabecera de la Reserva */}
                    <div 
                        onClick={() => toggleReserva(reserva.id)}
                        className="p-6 md:p-8 flex flex-col md:flex-row items-center gap-6 cursor-pointer hover:bg-slate-50/50 transition-colors"
                    >
                        <div className="w-16 h-16 bg-blue-50 rounded-2xl flex items-center justify-center shrink-0">
                        <CalendarIcon className="w-8 h-8 text-blue-600" />
                        </div>
                        
                        <div className="flex-1 text-center md:text-left">
                        <div className="flex flex-col md:flex-row md:items-center gap-2 md:gap-4 mb-1">
                            <span className="text-xs font-bold text-slate-400 uppercase tracking-widest">Reserva #00{reserva.id}</span>
                            <span className={`inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-bold uppercase mx-auto md:mx-0 ${
                            reserva.estado === 'Pendiente' ? 'bg-amber-100 text-amber-700' : 'bg-emerald-100 text-emerald-700'
                            }`}>
                            {reserva.estado === 'Pendiente' ? <ClockIcon className="w-3 h-3" /> : <CheckCircleIcon className="w-3 h-3" />}
                            {reserva.estado}
                            </span>
                        </div>
                        <div className="flex items-center justify-center md:justify-start gap-3 text-slate-800 font-bold text-sm">
                            <span>{new Date(reserva.fecha_ini).toLocaleDateString()}</span>
                            <ArrowLongRightIcon className="w-4 h-4 text-slate-500" />
                            <span>{new Date(reserva.fecha_fin).toLocaleDateString()}</span>
                        </div>
                        </div>

                        <div className="text-center md:text-right px-6 md:border-l border-slate-100">
                        <p className="text-[10px] font-bold text-slate-400 uppercase mb-1">Total Pagado</p>
                        <p className="text-2xl font-black text-blue-600">${reserva.total.toFixed(2)}</p>
                        </div>

                        <div className="text-slate-300 transition-all duration-300 ease-in-out">
                        {expandedReserva === reserva.id ? <ChevronUpIcon className="size-6 font-black" /> : <ChevronDownIcon className="size-6"/>}
                        </div>
                    </div>

                    {/* Detalles Expandibles (Array de Detalles -> Habitacion) */}
                    {expandedReserva === reserva.id && (
                        <div className="border-t border-slate-100 bg-slate-50/30 p-6 md:p-8 animate-in slide-in-from-top-2 duration-300">
                        <h4 className="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-6 flex items-center gap-2">
                            <BuildingOfficeIcon className="w-4 h-4" /> Desglose de Habitaciones
                        </h4>
                        
                        <div className="space-y-4">
                            {reserva.detalles.map((detalle, idx) => (
                            <div key={idx} className="bg-white p-4 rounded-3xl border border-slate-100 flex flex-col sm:flex-row gap-6 shadow-sm">
                                <img 
                                src={urlImage+detalle.habitacion.imagen} 
                                alt={detalle.habitacion.titulo?? ""}
                                className="w-full sm:w-32 h-24 object-cover rounded-2xl"
                                />
                                <div className="flex-1">
                                <div className="flex justify-between items-start mb-2">
                                    <div>
                                    <h5 className="font-bold text-slate-800">{detalle.habitacion.codigo} - {detalle.habitacion.tipo_habitacion}</h5>
                                    <p className="text-xs text-slate-500 line-clamp-1">{detalle.habitacion.descripcion}</p>
                                    </div>
                                    <span className="text-sm font-bold text-blue-600">${detalle.subtotal.toFixed(2)}</span>
                                </div>
                                
                                <div className="flex flex-wrap gap-3 mt-4">
                                    <span className="flex items-center gap-1.5 px-3 py-1 bg-slate-100 rounded-xl text-[10px] font-bold text-slate-600">
                                    <UsersIcon className="w-3 h-3" /> Capacidad: {detalle.habitacion.capacidad}
                                    </span>
                                    <span className={`flex items-center gap-1.5 px-3 py-1 rounded-xl text-[10px] font-bold ${
                                    detalle.estado === 'Pendiente' ? 'bg-amber-50 text-amber-600' : 'bg-emerald-50 text-emerald-600'
                                    }`}>
                                    <InformationCircleIcon className="w-3 h-3" /> {detalle.estado}
                                    </span>
                                </div>
                                </div>
                            </div>
                            ))}
                        </div>

                        <div className="mt-8 p-6 bg-blue-600 rounded-3xl text-white flex flex-col md:flex-row justify-between items-center gap-4">
                            <div className="flex items-center gap-4">
                            <CreditCardIcon className="w-10 h-10 opacity-50" />
                            <div>
                                <p className="text-xs font-medium opacity-80 uppercase tracking-wide">Método de Pago</p>
                                <p className="font-bold">Tarjeta de Crédito **** 4242</p>
                            </div>
                            </div>
                            <button className="px-8 py-3 bg-white text-blue-600 rounded-2xl font-bold text-sm shadow-lg hover:bg-blue-50 transition-all">
                            Descargar Comprobante PDF
                            </button>
                        </div>
                        </div>
                    )}
                    </div>
                ))}
                </div>

                {/* Empty State Mock */}
                {(Reservaciones === undefined || Reservaciones.length === 0) && (
                <div className="text-center py-20">
                    <div className="bg-white w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6 shadow-sm border border-slate-100">
                    <BuildingOfficeIcon className="w-10 h-10 text-slate-200" />
                    </div>
                    <h3 className="text-xl font-bold text-slate-800">No hay reservaciones</h3>
                    <p className="text-slate-500 max-w-xs mx-auto mt-2">Parece que aún no has realizado ninguna reserva en nuestro hotel.</p>
                    <NavLink to={"/habitaciones"} className="mt-8 px-8 py-4 bg-blue-600 text-white rounded-2xl font-bold shadow-xl shadow-blue-100">Explorar Habitaciones</NavLink>
                </div>
                )}
            </div>
        </div>
    )
}