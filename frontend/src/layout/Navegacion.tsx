import { useState } from "react";
import { NavLink } from "react-router-dom";
// Tus hooks personalizados
import useLocalStorage from "../hooks/useLocalstorage";
import useAuth from "../features/Auth/hooks/useAuth";
import type { TinfoUser } from "../types";

// Heroicons - Usamos la versión "outline" para los menús (más elegante) y "solid" para cosas destacadas
import { 
    UserCircleIcon, 
    Cog6ToothIcon 
} from "@heroicons/react/24/solid";
import {
    ChevronDownIcon,
    CalendarDaysIcon,
    HomeModernIcon,
    UserGroupIcon,
    ArrowRightOnRectangleIcon,
    BuildingOfficeIcon
} from "@heroicons/react/24/outline";

import { useNavigate } from "react-router-dom";

export default function Navegacion() {
    // ---- HOOKS & STATES ----
    const { getDataLocalStorage } = useLocalStorage();
    const { logout } = useAuth();
    
    const [showReserva, setShowReserva] = useState(false);
    const [showHabitacion, setShowHabitacion] = useState(false);
    const [showPersonal, setShowPersonal] = useState(false);
    const [showDropdown, setShowDropdown] = useState(false);
    const navigate = useNavigate();
    const usuarioInfo: TinfoUser = getDataLocalStorage("usuario");

    if (!usuarioInfo) {
        console.warn("Sin datos de usuario en localStorage");
    }

    // ---- HANDLERS ----
    const handleLogout = async (ev: React.MouseEvent<HTMLButtonElement>) => {
        ev.preventDefault();
        await logout();
        navigate("/iniciarSesion", {replace: true})
    };

    // ---- TAILWIND STYLES (Variables para código limpio) ----
    const navLinkStyles = ({ isActive }: { isActive: boolean }) =>
        `flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all duration-300 w-full text-base font-medium ${
            isActive
                ? "bg-emerald-500/15 text-emerald-400 shadow-sm"
                : "text-slate-400 hover:bg-slate-800/50 hover:text-slate-200"
        }`;

    const subNavLinkStyles = ({ isActive }: { isActive: boolean }) =>
        `flex items-center gap-3 px-4 py-2 rounded-lg transition-all duration-200 w-full text-sm font-medium pl-11 ${
            isActive
                ? "bg-emerald-500/10 text-emerald-400"
                : "text-slate-400 hover:text-emerald-300 hover:bg-slate-800/30"
        }`;

    const accordionBtnStyles = (isOpen: boolean) =>
        `flex items-center justify-between w-full px-4 py-2.5 rounded-xl transition-all duration-300 text-base font-medium cursor-pointer ${
            isOpen
                ? "bg-slate-800/80 text-white"
                : "text-slate-400 hover:bg-slate-800/50 hover:text-slate-200"
        }`;

    return (
        <aside className="bg-slate-900 border-r border-slate-800 h-screen w-72 flex flex-col justify-between shadow-2xl transition-all font-sans">
            
            {/* ---- LOGO / BRANDING HEADER ---- */}
            <div className="p-6 border-b border-slate-800 flex items-center gap-3">
                <div className="bg-emerald-600/20 p-2 rounded-xl text-emerald-500">
                    <BuildingOfficeIcon className="size-8" />
                </div>
                <div>
                    <h1 className="text-white text-xl font-bold tracking-wide">Grand<span className="text-emerald-500">Hotel</span></h1>
                    <p className="text-slate-500 text-xs font-medium tracking-widest uppercase">Management</p>
                </div>
            </div>

            {/* ---- MAIN NAVIGATION ---- */}
            <nav className="flex-1 overflow-y-auto p-4 space-y-2 custom-scrollbar">
                <ul className="space-y-2">
                    
                    {/* 1. SECCIÓN RECEPCIONES */}
                    {/* Se muestra si es admin, recepcionista, o cliente (para "Mis reservas") */}
                    {(usuarioInfo?.rol === "recepcionista" || usuarioInfo?.rol === "admin" || !usuarioInfo?.rol /* Asumiendo que cliente no tiene rol específico o es otro */) && (
                        <li>
                            <button onClick={() => setShowReserva(!showReserva)} className={accordionBtnStyles(showReserva)}>
                                <div className="flex items-center gap-3">
                                    <CalendarDaysIcon className="size-5" />
                                    <span>Recepciones</span>
                                </div>
                                <ChevronDownIcon className={`size-4 transition-transform duration-300 ${showReserva ? "rotate-180 text-emerald-400" : ""}`} />
                            </button>
                            
                            <ul className={`overflow-hidden transition-all duration-500 ease-in-out ${showReserva ? "max-h-40 mt-1 space-y-1" : "max-h-0"}`}>
                                {(usuarioInfo?.rol === "recepcionista" || usuarioInfo?.rol === "admin") ? (
                                    <>
                                        <li>
                                            <NavLink to="reservarhabitacion" className={subNavLinkStyles}>
                                                Reserva Manual
                                            </NavLink>
                                        </li>
                                        <li>
                                            <NavLink to="reservaciones" className={subNavLinkStyles}>
                                                Todas las Reservas
                                            </NavLink>
                                        </li>
                                    </>
                                ) : (
                                    <li>
                                        <NavLink to="reservaciones" className={subNavLinkStyles}>
                                            Mis Reservaciones
                                        </NavLink>
                                    </li>
                                )}
                            </ul>
                        </li>
                    )}

                    {/* 2. SECCIÓN HABITACIONES */}
                    <li>
                        {(usuarioInfo?.rol === "admin" || usuarioInfo?.rol === "recepcionista") ? (
                            <>
                                <button onClick={() => setShowHabitacion(!showHabitacion)} className={accordionBtnStyles(showHabitacion)}>
                                    <div className="flex items-center gap-3">
                                        <HomeModernIcon className="size-5" />
                                        <span>Habitaciones</span>
                                    </div>
                                    <ChevronDownIcon className={`size-4 transition-transform duration-300 ${showHabitacion ? "rotate-180 text-emerald-400" : ""}`} />
                                </button>
                                <ul className={`overflow-hidden transition-all duration-500 ease-in-out ${showHabitacion ? "max-h-40 mt-1 space-y-1" : "max-h-0"}`}>
                                    <li>
                                        <NavLink to="/habitaciones/nueva" className={subNavLinkStyles}>
                                            Nueva Habitación
                                        </NavLink>
                                    </li>
                                    <li>
                                        <NavLink to="habitaciones" className={subNavLinkStyles}>
                                            Ver Habitaciones
                                        </NavLink>
                                    </li>
                                </ul>
                            </>
                        ) : (
                            // Vista para clientes comunes
                            <NavLink to="habitaciones" className={navLinkStyles}>
                                <HomeModernIcon className="size-5" />
                                <span>Habitaciones </span>
                            </NavLink>
                        )}
                    </li>
                    
                    {usuarioInfo?.rol === "cliente" && (
                        <>
                            <li>
                                <NavLink to="misreservaciones" className={navLinkStyles}>
                                    Mis Reservaciones
                                </NavLink>
                            </li>
                            <li>
                                <NavLink to="reservas/nueva" className={navLinkStyles}>
                                    Reservar
                                </NavLink>
                            </li>
                        </>
                    )}

                    {/* 3. SECCIÓN PERSONAL (Solo Admin) */}
                    {usuarioInfo?.rol === "admin" && (
                        <li>
                            <button onClick={() => setShowPersonal(!showPersonal)} className={accordionBtnStyles(showPersonal)}>
                                <div className="flex items-center gap-3">
                                    <UserGroupIcon className="size-5" />
                                    <span>Gestión Personal</span>
                                </div>
                                <ChevronDownIcon className={`size-4 transition-transform duration-300 ${showPersonal ? "rotate-180 text-emerald-400" : ""}`} />
                            </button>
                            <ul className={`overflow-hidden transition-all duration-500 ease-in-out ${showPersonal ? "max-h-40 mt-1 space-y-1" : "max-h-0"}`}>
                                <li>
                                    <NavLink to="personal" className={subNavLinkStyles}>
                                        Ver Personal
                                    </NavLink>
                                </li>
                                <li>
                                    <NavLink to="personal/nuevo" className={subNavLinkStyles}>
                                        Nuevo Personal
                                    </NavLink>
                                </li>
                            </ul>
                        </li>
                    )}
                </ul>
            </nav>

            {/* ---- FOOTER / PERFIL DE USUARIO ---- */}
            <section className="p-4 border-t border-slate-800 bg-slate-900 relative">
                
                {/* Menú Dropdown (Cerrar sesión) */}
                <div className={`absolute bottom-20 left-4 right-4 bg-slate-800 border border-slate-700 rounded-xl shadow-xl transition-all duration-200 transform origin-bottom ${showDropdown ? "opacity-100 scale-100 visible" : "opacity-0 scale-95 invisible"}`}>
                    <div className="p-2">
                        <button 
                            onClick={handleLogout} 
                            className="w-full flex items-center gap-3 px-3 py-2 rounded-lg text-red-400 hover:bg-red-500/10 hover:text-red-300 transition-colors font-medium"
                        >
                            <ArrowRightOnRectangleIcon className="size-5" />
                            Cerrar Sesión
                        </button>
                    </div>
                </div>

                {/* Info de Perfil */}
                <div className="flex items-center justify-between p-2 hover:bg-slate-800 rounded-xl transition-colors">
                    <div className="flex items-center gap-3 overflow-hidden">
                        <UserCircleIcon className="size-11 text-slate-400" />
                        <div className="flex flex-col truncate">
                            <span className="text-white text-sm font-bold truncate">{usuarioInfo?.name || "Usuario"}</span>
                            <span className="text-emerald-500 text-xs font-semibold capitalize tracking-wide">{usuarioInfo?.rol || "Huésped"}</span>
                        </div>
                    </div>
                    <button 
                        onClick={() => setShowDropdown(!showDropdown)} 
                        className={`p-2 rounded-lg transition-colors ${showDropdown ? "bg-slate-700 text-white" : "text-slate-400 hover:text-white"}`}
                    >
                        <Cog6ToothIcon className="size-6" />
                    </button>
                </div>
            </section>

        </aside>
    );
}