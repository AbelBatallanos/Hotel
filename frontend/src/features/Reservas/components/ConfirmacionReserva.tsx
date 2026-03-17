import { CalendarIcon, ChevronLeftIcon, ClockIcon, CreditCardIcon, UserIcon, TrashIcon, EllipsisHorizontalIcon, CheckCircleIcon, ExclamationCircleIcon } from "@heroicons/react/24/solid";
import type {TReservaConfirmacion, } from "../types"
import { urlImage } from "../../../api/axios";


interface TConfirmacionReserva {
    reservaDetalles: TReservaConfirmacion
    setSelectedReserva:  React.Dispatch<boolean>;

}




export default function ConfirmacionReserva({reservaDetalles, setSelectedReserva}: TConfirmacionReserva){
    
    return(
        <>
            <div className="min-h-screen bg-[#f8fafc] p-4 lg:p-10">
                <div className="max-w-5xl mx-auto">
                    {/* Header Detalle */}
                    <div className="flex items-center justify-between mb-8">
                    <button 
                        onClick={() => setSelectedReserva(false)}
                        className="flex items-center gap-2 text-slate-500 font-bold hover:text-slate-800 transition-all bg-white px-5 py-3 rounded-2xl shadow-sm border border-slate-200"
                    >
                        <ChevronLeftIcon className="w-5 h-5" /> Volver al Listado
                    </button>
                    <div className="flex items-center gap-3">
                        <span className="bg-amber-500/10 text-amber-600 px-4 py-2 rounded-xl text-xs font-bold border border-amber-500/20">
                        Gestión de Check-in
                        </span>
                    </div>
                    </div>

                    <div className="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    {/* Columna Izquierda: Detalles del Cliente y Reserva */}
                    <div className="lg:col-span-2 space-y-6">
                        <div className="bg-white rounded-[2.5rem] p-8 shadow-sm border border-slate-200 relative overflow-hidden">
                        <div className="absolute top-0 right-0 p-8">
                            <ClockIcon className="w-16 h-16 text-slate-50 opacity-10 rotate-12" />
                        </div>
                        
                        <div className="flex items-center gap-6 mb-8">
                            <div className="w-20 h-20 bg-slate-100 rounded-3xl flex items-center justify-center text-slate-400">
                            <UserIcon className="w-10 h-10" />
                            </div>
                            <div>
                            <p className="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] mb-1">Titular de la Reserva</p>
                            <h3 className="text-3xl font-black text-slate-900">{reservaDetalles?.usuario?.name}</h3>
                            <p className="text-slate-500 font-medium">{reservaDetalles?.usuario?.email}</p>
                            </div>
                        </div>

                        <div className="grid grid-cols-2 gap-4">
                            <div className="bg-slate-50 p-6 rounded-3xl border border-slate-100">
                            <p className="text-[10px] font-bold text-slate-400 uppercase mb-2">Fecha de Entrada</p>
                            <p className="text-lg font-black text-slate-800 flex items-center gap-2">
                                <CalendarIcon className="w-5 h-5 text-blue-500" /> {reservaDetalles.fecha_ini}
                            </p>
                            </div>
                            <div className="bg-slate-50 p-6 rounded-3xl border border-slate-100">
                            <p className="text-[10px] font-bold text-slate-400 uppercase mb-2">Fecha de Salida</p>
                            <p className="text-lg font-black text-slate-800 flex items-center gap-2">
                                <CalendarIcon className="w-5 h-5 text-rose-500" /> {reservaDetalles.fecha_fin}
                            </p>
                            </div>
                        </div>
                        </div>

                        {/* Listado de Habitaciones para Confirmar */}
                        <div className="space-y-4">
                        <h4 className="text-sm font-bold text-slate-400 uppercase tracking-widest px-4 flex justify-between items-center">
                            Habitaciones Solicitadas 
                            <span className="bg-slate-200 text-slate-600 px-2 py-0.5 rounded-lg text-[10px]">{reservaDetalles.detalles.length}</span>
                        </h4>
                        
                        {reservaDetalles.detalles.map((detalle, idx) => (
                            <div key={idx} className="bg-white rounded-3xl p-5 border border-slate-200 flex flex-col sm:flex-row items-center gap-6 group hover:border-blue-200 transition-all">
                            <div className="relative w-full sm:w-32 h-24 shrink-0 overflow-hidden rounded-2xl">
                                <img src={`${urlImage}${detalle.habitacion.imagen}`} className="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" />
                                <div className="absolute inset-0 bg-black/20"></div>
                                <div className="absolute top-2 left-2 bg-white/90 backdrop-blur-md px-2 py-1 rounded-lg text-[10px] font-bold text-slate-800">
                                {detalle.habitacion.codigo}
                                </div>
                            </div>

                            <div className="flex-1 text-center sm:text-left">
                                <div className="flex items-center justify-center sm:justify-start gap-2 mb-1">
                                <h5 className="font-black text-slate-800 uppercase">{detalle.habitacion.tipo_habitacion}</h5>
                                </div>
                                <p className="text-xs text-slate-500">Capacidad: {detalle.habitacion.capacidad} personas</p>
                                <div className="mt-3 flex items-center justify-center sm:justify-start gap-4">
                                <span className="text-blue-600 font-black text-lg">${detalle.subtotal.toFixed(2)}</span>
                                </div>
                            </div>

                            <div className="flex items-center gap-2 px-6 sm:border-l border-slate-100">
                                <button className="p-3 text-rose-400 hover:text-rose-600 hover:bg-rose-50 rounded-2xl transition-all" title="Eliminar de la reserva">
                                <TrashIcon className="w-5 h-5" />
                                </button>
                                <button className="p-3 text-slate-300 hover:text-blue-600 hover:bg-blue-50 rounded-2xl transition-all">
                                <EllipsisHorizontalIcon className="w-5 h-5" />
                                </button>
                            </div>
                            </div>
                        ))}
                        </div>
                    </div>

                    {/* Columna Derecha: Confirmación de Pago y Registro */}
                    <div className="lg:col-span-1 space-y-6">
                        <div className="bg-slate-900 rounded-[2.5rem] p-8 text-white shadow-2xl shadow-blue-900/20 sticky top-10">
                        <h4 className="text-lg font-bold mb-6 flex items-center gap-2">
                            <CreditCardIcon className="w-5 h-5 text-blue-400" /> Resumen Final
                        </h4>
                        
                        <div className="space-y-4 mb-8">
                            <div className="flex justify-between text-sm">
                            <span className="text-slate-400">Subtotal Reserva</span>
                            <span className="font-bold">${reservaDetalles.total.toFixed(2)}</span>
                            </div>
                            <div className="flex justify-between text-sm">
                            <span className="text-slate-400">Servicios Adic.</span>
                            <span className="font-bold text-emerald-400">$0.00</span>
                            </div>
                            <div className="h-px bg-white/10 my-4"></div>
                            <div className="flex justify-between items-center">
                            <span className="text-lg font-bold">Total a Cobrar</span>
                            <span className="text-3xl font-black text-blue-400">${reservaDetalles.total.toFixed(2)}</span>
                            </div>
                        </div>

                        <div className="space-y-3">
                            <button className="w-full py-5 bg-blue-600 hover:bg-blue-500 text-white rounded-[1.5rem] font-black shadow-lg shadow-blue-600/20 transition-all flex items-center justify-center gap-3 group">
                            <CheckCircleIcon className="w-6 h-6 group-hover:scale-110 transition-transform" />
                            CONFIRMAR CHECK-IN
                            </button>
                            <p className="text-[10px] text-center text-slate-500 leading-relaxed px-4">
                            Al confirmar, las habitaciones pasarán a estado <span className="text-blue-400 font-bold">OCUPADO</span> y se generará el folio de registro oficial.
                            </p>
                        </div>

                        <div className="mt-8 pt-8 border-t border-white/5 space-y-4">
                            <div className="flex items-center gap-3 text-xs text-slate-400">
                            <div className="w-8 h-8 rounded-full bg-white/5 flex items-center justify-center">
                                <ExclamationCircleIcon className="w-4 h-4 text-amber-500" />
                            </div>
                            <p>Verifique que el pago haya sido procesado antes de entregar las llaves.</p>
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </>
    )
}