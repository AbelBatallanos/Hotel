import type { ResponseServidorErrors } from "../../../types";
import type{ ThabitacionData, TiposHabitacionT } from "../types";

import {PhotoIcon, HashtagIcon, UsersIcon ,BookmarkSquareIcon, InformationCircleIcon, QueueListIcon} from "@heroicons/react/24/solid";

interface FormCrearHabitacion {
    handleSubmit : (ev: React.FormEvent<HTMLFormElement>)=> void;
    habitacionData: ThabitacionData;
    handleChange: (data: React.ChangeEvent<HTMLInputElement>)=> any;
    handleImagenChange: (e: React.ChangeEvent<HTMLInputElement>)=> any;
    preview: string | null;
    ListTiposHabitaciones: TiposHabitacionT[];
    msg : ResponseServidorErrors["msg"];
}

export default function FormCrearHabitacion({handleSubmit, habitacionData, handleChange, handleImagenChange, preview, ListTiposHabitaciones, msg} : FormCrearHabitacion){

    

    return (
        <div className="min-h-screen bg-slate-50 p-6 md:p-10 font-sans text-slate-800">
            {/* Contenedor principal más ancho para aprovechar la pantalla */}
            <div className="max-w-5xl mx-auto">
                
                {/* Encabezado de la sección */}
                <div className="mb-8 flex items-center gap-3">
                    <div className="p-3 bg-blue-600 rounded-lg text-white shadow-md">
                        <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAACXBIWXMAAAsTAAALEwEAmpwYAAAApElEQVR4nO2U3QrCMAxGc6E+lL6ezvqco/oYR1Yq9KI/Y0s3xZyrQkJyCB8VMQwjATgBD+CJPh64TzukBODoz1AT8LHpLMoAl88lak0B7eWz5/NtAtRD+YqZcfHdDN0SAYdi6JYI+FIok1C16n6NQGBu/6p5wJHtOOQEbhsKXHMCY69PKJOLMVcM9Fre3EOpYAJ/KUAnfkMgRfvs1dnsLWAYshNvULBo64fKweMAAAAASUVORK5CYII=" alt="bed"></img>
                    </div>
                    <div>
                        <h1 className="text-3xl font-extrabold text-slate-900 tracking-tight">Nueva Habitación</h1>
                        <p className="text-slate-500 mt-1">Completa los datos para registrar una nueva habitación en el sistema.</p>
                    </div>
                </div>

                {/* Tarjeta del Formulario */}
                <form 
                    onSubmit={handleSubmit} 
                    className="bg-white rounded-2xl shadow-sm border border-slate-200 p-8 space-y-8"
                >
                    {/* Grid para poner campos en 2 columnas en pantallas medianas/grandes */}
                    <div className="grid grid-cols-1 md:grid-cols-2 gap-8">
                        
                        {/* Campo: Código */}
                        <div className="flex flex-col space-y-2">
                            <label className="text-sm font-semibold text-slate-700 flex items-center gap-2">
                                <HashtagIcon  className="text-slate-400 size-5" />
                                Código de Habitación
                            </label>
                            <input 
                                type="text" 
                                name="codigo" 
                                value={habitacionData.codigo} 
                                onChange={handleChange} 
                                placeholder="Ej: HAB-101"
                                className="w-full border border-slate-300 rounded-lg p-3 outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all bg-slate-50 hover:bg-white focus:bg-white" 
                                required 
                            />
                        </div>

                        {/* Campo: Capacidad */}
                        <div className="flex flex-col space-y-2">
                            <label className="text-sm font-semibold text-slate-700 flex items-center gap-2">
                                <UsersIcon  className="text-slate-400 size-5" />
                                Capacidad (Personas)
                            </label>
                            <input 
                                type="number" 
                                name="capacidad" 
                                min="1"
                                value={habitacionData.capacidad} 
                                onChange={handleChange} 
                                placeholder="Ej: 2"
                                className="w-full border border-slate-300 rounded-lg p-3 outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all bg-slate-50 hover:bg-white focus:bg-white" 
                                required 
                            />
                        </div>

                        {/* Campo: Tipo de Habitación */}
                        <div className="flex flex-col space-y-2 md:col-span-2">
                            <label className="text-sm font-semibold text-slate-700 flex items-center gap-2">
                                <QueueListIcon  className="text-slate-400 size-5" />
                                Tipo de Habitación
                            </label>
                            <select 
                                name="tipo_habitacion_id" 
                                id="tipo_habitacion_id" 
                                onChange={handleChange}
                                value={habitacionData.tipo_habitacion_id}
                                className="w-full border border-slate-300 rounded-lg p-3 outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all bg-slate-50 hover:bg-white focus:bg-white cursor-pointer"
                                required
                            >
                                <option value="" disabled>---- Selecciona un tipo ----</option>
                                {ListTiposHabitaciones.map((tipohab) => (
                                    <option key={tipohab.id} value={tipohab.id}>{tipohab.nombre}</option>
                                ))}
                            </select>
                        </div>

                        {/* Campo: Descripción (Ocupa las 2 columnas) */}
                        <div className="flex flex-col space-y-2 md:col-span-2">
                            <label className="text-sm font-semibold text-slate-700 flex items-center gap-2" htmlFor="descripcion">
                                <InformationCircleIcon  className="text-slate-400 size-5" />
                                Descripción y Amenidades
                            </label>
                            <textarea 
                                name="descripcion" 
                                id="descripcion" 
                                value={habitacionData.descripcion} // Corrección de React: usar value en lugar de children
                                onChange={handleChange}
                                placeholder="Describe las características de la habitación, vista, mobiliario incluido..."
                                className="w-full border border-slate-300 rounded-lg p-3 min-h-[120px] outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all bg-slate-50 hover:bg-white focus:bg-white resize-y"
                            />
                        </div>

                        {/* Campo: Subir Imagen (Ocupa las 2 columnas) */}
                        <div className="flex flex-col space-y-3 md:col-span-2">
                            <label className="text-sm font-semibold text-slate-700 flex items-center gap-2">
                                <PhotoIcon className="text-slate-400 size-5" />
                                Fotografía Principal
                            </label>
                            
                            <div className="flex flex-col sm:flex-row gap-6 items-start">
                                {/* Input de archivo estilizado */}
                                <div className="w-full sm:w-1/2">
                                    <label className="flex flex-col items-center justify-center w-full h-32 border-2 border-slate-300 border-dashed rounded-xl cursor-pointer bg-slate-50 hover:bg-slate-100 transition-colors group">
                                        <div className="flex flex-col items-center justify-center pt-5 pb-6">
                                            <PhotoIcon className="w-12 h-12 mb-3 text-slate-400 group-hover:text-blue-500 transition-colors" />
                                            <p className="mb-2 text-sm text-slate-500"><span className="font-semibold text-blue-600">Haz clic para subir</span> o arrastra</p>
                                            <p className="text-xs text-slate-400">PNG, JPG, JPEG (Max. 2MB)</p>
                                        </div>
                                        <input 
                                            type="file" 
                                            accept="image/*" 
                                            name="imagen" 
                                            id="imagen" 
                                            onChange={handleImagenChange} 
                                            className="hidden" 
                                            required={!preview} 
                                        />
                                    </label>
                                </div>

                                {/* Vista Previa */}
                                <div className="w-full sm:w-1/2 flex justify-center sm:justify-start">
                                    {preview ? (
                                        <div className="relative rounded-xl overflow-hidden border border-slate-200 shadow-sm w-full h-32 bg-slate-100">
                                            <img src={preview} alt="Vista previa" className="w-full h-full object-cover" />
                                        </div>
                                    ) : (
                                        <div className="flex items-center justify-center w-full h-32 border border-slate-200 rounded-xl bg-slate-100 text-slate-400 text-sm">
                                            Sin vista previa
                                        </div>
                                    )}
                                </div>
                            </div>
                        </div>

                    </div>

                    {/* Botones de acción */}
                    <div className="pt-6 border-t border-slate-100 flex justify-end gap-4">
                        <button 
                            type="button" 
                            className="px-6 py-2.5 rounded-lg text-slate-600 font-medium hover:bg-slate-100 transition-colors"
                        >
                            Cancelar
                        </button>
                        <button 
                            type="submit" 
                            className="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 px-8 rounded-lg shadow-sm hover:shadow transition-all flex items-center gap-2 focus:ring-4 focus:ring-blue-100"
                        >
                            <BookmarkSquareIcon className="size-5" />
                            Registrar Habitación
                        </button>
                    </div>
                </form>
            </div>
            { msg && (<p className="bg-emerald-600 text-center w-2/4 uppercase text-white p-2 rounded-xl font-bold mt-4 mx-auto">{msg}</p>)}
        </div>
    );
}