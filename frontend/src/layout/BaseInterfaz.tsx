import { Outlet } from "react-router-dom";
import Navegacion from "./Navegacion";
import { Bars3Icon, BuildingOfficeIcon, XMarkIcon } from "@heroicons/react/24/solid";
import { useState } from "react";



export default function BaseInterfaz(){
    const [isMenuOpen, setIsMenuOpen] = useState(false);
    return(
        <div className="min-h-screen bg-slate-50 flex flex-col md:flex-row overflow-x-hidden">
            
            {/* Header Móvil (Solo visible en pantallas < 768px) */}
            <header className="md:hidden bg-[#0f172a] text-white p-4 flex justify-between items-center sticky top-0 z-50 shadow-lg">
                <div className="flex items-center gap-2">
                    <div className="size-8 bg-emerald-500 rounded-lg flex items-center justify-center">
                        <BuildingOfficeIcon className="size-5 text-white" />
                    </div>
                    <span className="font-bold tracking-tight">GrandHotel</span>
                </div>
                <button 
                    onClick={() => setIsMenuOpen(!isMenuOpen)}
                    className="p-2 text-slate-300 hover:bg-slate-800 rounded-lg transition-colors"
                >
                    {isMenuOpen ? <XMarkIcon className="size-6" /> : <Bars3Icon className="size-6" />}
                </button>
            </header>

            {/* Navegación Lateral (Sidebar) */}
            {/* - En escritorio (md:): Ancho fijo y angosto (w-64 o w-[240px]). 
                - En móvil: Se desliza desde la izquierda.
            */}
            <aside className={`
                fixed inset-y-0 left-0 z-40 w-[260px] transform transition-transform duration-300 ease-in-out
                md:relative md:translate-x-0 md:w-[260px] lg:w-[220px] xl:w-[240px] flex-shrink-0
                ${isMenuOpen ? "translate-x-0" : "-translate-x-full"}
            `}>
                <Navegacion />
            </aside>

            {/* Overlay para cerrar el menú móvil al tocar el fondo */}
            {isMenuOpen && (
                <div 
                    className="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-30 md:hidden"
                    onClick={() => setIsMenuOpen(false)}
                ></div>
            )}

            {/* Contenido Principal (Main) */}
            {/* - flex-1: Ocupa todo el espacio restante disponible.
                - max-w-full: Previene que el grid de habitaciones rompa el layout en pantallas grandes.
            */}
            <main className="flex-1 w-full relative h-screen overflow-y-auto overflow-x-hidden">
                <div className="p-4 md:p-8 lg:p-12 w-full max-w-[1920px] mx-auto">
                    {/* El Outlet renderiza aquí Habitaciones.tsx o cualquier sub-ruta */}
                    <Outlet />
                </div>
            </main>
        </div>
    );

}