import useReserva from "../hook/useReserva";
import {CreditCardIcon, CalendarDaysIcon, BuildingOfficeIcon,UsersIcon, ExclamationCircleIcon, TrashIcon} from "@heroicons/react/24/solid"
import useAppStore from "../../../store/appStore"
import { urlImage } from "../../../api/axios";


export default function CrearReserva(){

    const {CrearReserva, ErrorHabitacionesOcupadas} = useReserva();
    const {habitacionesList, Reservacion,insertarHabitacionId, eliminarHabitacion, limpiarTodo} = useAppStore();

   const RealizarReservacion = async()=>{
       // 1. Validación temprana: Si no hay nada en el carrito, no hacemos nada
        if (habitacionesList.length === 0) {
            console.warn("No hay habitaciones seleccionadas");
            return;
        }

        // 2. Construimos el payload directamente de habitacionesList
        // Esto evita esperar a que Reservacion.habitaciones se actualice
        const ids = habitacionesList.map(h => ({id: h.id}));
        
        const payload = {
            habitaciones: ids,
            // Aquí puedes agregar fechas si las tienes en un estado local
        };

        console.log("Enviando Payload:", payload);
        try {
            // 3. Llamada al servicio
            const respuesta = await CrearReserva(payload);
            
            if (respuesta) {
                console.log("Reserva exitosa");
                limpiarTodo(); // Solo limpiamos si el servidor confirmó
            }
        } catch (error) {
            console.error("Error al realizar la reservación", error);
        }
   }

    return(
        <>
         <div className="max-w-5xl mx-auto animate-in fade-in duration-500">
            {/* Header Reserva */}
            <div className="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8">
              <div>
                <div className="inline-flex items-center gap-2 px-3 py-1 bg-blue-50 text-blue-600 rounded-full text-[10px] font-bold uppercase tracking-wider mb-2">
                  <CalendarDaysIcon className="w-3 h-3" /> Configuración de Estancia
                </div>
                <h2 className="text-3xl font-extrabold text-slate-800">Finalizar Reserva</h2>
                <p className="text-slate-500">Revisa las habitaciones seleccionadas antes de confirmar la reservación.</p>
              </div>
              <div className="flex bg-white p-2 rounded-2xl shadow-sm border border-slate-200 gap-4">
                <div className="px-4 py-1 border-r border-slate-100">
                  <p className="text-[10px] font-bold text-slate-400 uppercase">Llegada</p>
                  <p className="text-sm font-semibold text-slate-700">12 Mar 2024</p>
                </div>
                <div className="px-4 py-1">
                  <p className="text-[10px] font-bold text-slate-400 uppercase">Salida</p>
                  <p className="text-sm font-semibold text-slate-700">15 Mar 2024</p>
                </div>
              </div>
            </div>

            <div className="grid grid-cols-1 lg:grid-cols-3 gap-8">
              {/* Listado de Habitaciones Seleccionadas */}
              <div className="lg:col-span-2 space-y-4">
                <h3 className="text-sm font-bold text-slate-400 uppercase tracking-widest flex items-center gap-2 mb-4">
                  <BuildingOfficeIcon className="w-4 h-4" /> Habitaciones Seleccionadas ({habitacionesList.length})
                </h3>
                
                {habitacionesList.length > 0 ? (
                  habitacionesList.map((hab) => (
                    <div key={hab.id} className="bg-white rounded-3xl border border-slate-200 p-4 flex gap-6 hover:shadow-md transition-shadow group relative overflow-hidden">
                      {ErrorHabitacionesOcupadas.error && ErrorHabitacionesOcupadas.ocupadas.some( ocupado => ocupado.codigo === hab.codigo) && (<div className="absolute bg-red-200/50 inset-0 z-10  flex items-center justify-center"><p className="text-center text-lime-800 sm:text-2xl lg:text-3xl font-bold uppercase">habitación Ocupada</p></div>)}
                      {/* Imagen con badge de precio */}
                      <div className="relative w-40 h-32 z-0 shrink-0 overflow-hidden rounded-2xl shadow-inner bg-slate-100">
                        <img src={urlImage+hab.imagen} alt={hab.titulo} className="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" />
                        <div className="absolute top-2 left-2 bg-slate-900/80 backdrop-blur-md text-white px-2 py-1 rounded-lg text-[10px] font-bold">
                          {hab.codigo}
                        </div>
                      </div>

                      {/* Info Detallada */}
                      <div className="flex-1 flex flex-col justify-between py-1">
                        <div>
                          <div className="flex justify-between items-start">
                            <h4 className="font-bold text-slate-800 text-lg leading-tight mb-1">{hab.titulo}</h4>
                            <span className="text-emerald-600 font-black text-xl">${hab.precio}<span className="text-[10px] text-slate-400 font-normal">/noche</span></span>
                          </div>
                          <p className="text-slate-500 text-xs line-clamp-2 mb-3 leading-relaxed">{hab.descripcion?? "Sin Descripción"}</p>
                        </div>

                        <div className="flex items-center gap-4">
                          <div className="flex items-center gap-1.5 px-3 py-1 bg-slate-50 border border-slate-100 rounded-full text-[10px] font-bold text-slate-600">
                            <UsersIcon className="w-3 h-3 text-slate-400" /> {hab.capacidad}
                          </div>
                          <div className="flex items-center gap-1.5 px-3 py-1 bg-slate-50 border border-slate-100 rounded-full text-[10px] font-bold text-slate-600">
                            <ExclamationCircleIcon className="w-3 h-3 text-slate-400" /> {hab.tipo_habitacion}
                          </div>
                          
                          {/* Botón Eliminar - Se ejecuta al hacer clic */}
                          <button 
                            onClick={() => eliminarHabitacion(hab.id)}
                            className="ml-auto flex items-center z-10 cursor-pointer gap-2 text-rose-500 hover:bg-rose-50 px-3 py-1.5 rounded-xl text-xs font-bold transition-colors"
                          >
                            <TrashIcon className="w-3.5 h-3.5" />
                            Quitar
                          </button>
                        </div>
                      </div>
                    </div>
                  ))
                ) : (
                  <div className="bg-slate-100/50 border-2 border-dashed border-slate-200 rounded-3xl p-12 text-center">
                    <BuildingOfficeIcon className="w-12 h-12 text-slate-300 mx-auto mb-4" />
                    <p className="text-slate-500 font-medium">No has seleccionado ninguna habitación todavía.</p>
                  </div>
                )}
              </div>

              {/* Resumen de Reserva */}
              <div className="lg:col-span-1">
                <div className="bg-white rounded-3xl border border-slate-200 p-6 sticky top-8">
                  <h3 className="text-lg font-bold text-slate-800 mb-6 flex items-center gap-2">
                    <CreditCardIcon className="w-5 h-5 text-emerald-500" /> Resumen de Pago
                  </h3>
                  
                  <div className="space-y-4 mb-8">
                    <div className="flex justify-between text-sm">
                      <span className="text-slate-500">Subtotal Habitaciones</span>
                      <span className="font-bold text-slate-700">${habitacionesList.reduce((acc, curr) => acc + parseFloat(curr.precio), 0).toFixed(2)}</span>
                    </div>
                    <div className="flex justify-between text-sm">
                      <span className="text-slate-500">Impuestos (IVA 15%)</span>
                      <span className="font-bold text-slate-700">${(habitacionesList.reduce((acc, curr) => acc + parseFloat(curr.precio), 0) * 0.15).toFixed(2)}</span>
                    </div>
                    <div className="h-px bg-slate-100 my-4"></div>
                    <div className="flex justify-between items-center">
                      <span className="text-slate-800 font-bold">Total a Pagar</span>
                      <span className="text-2xl font-black text-emerald-600">
                        ${(habitacionesList.reduce((acc, curr) => acc + parseFloat(curr.precio), 0) * 1.15).toFixed(2)}
                      </span>
                    </div>
                  </div>

                  <button type="button" onClick={RealizarReservacion} className="w-full py-4 bg-emerald-500 hover:bg-emerald-600 text-white rounded-2xl font-bold shadow-lg shadow-emerald-100 transition-all flex items-center justify-center gap-3 active:scale-[0.98]">
                    Confirmar Reservación
                  </button>
                  <p className="text-[10px] text-center text-slate-400 mt-4 leading-relaxed">
                    Al confirmar, se guardarán los IDs de las habitaciones en el sistema de reservas.
                  </p>
                </div>
              </div>
            </div>
          </div>
        </>
    );
}