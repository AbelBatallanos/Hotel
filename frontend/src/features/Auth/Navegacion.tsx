
import {NavLink} from "react-router-dom";
import useLocalStorage from "../../hooks/useLocalstorage";
import { BuildingOfficeIcon } from "@heroicons/react/24/solid";


export default function Navegacion(){
    const {getDataLocalStorage} = useLocalStorage();
    console.log(getDataLocalStorage("usuario"))

    
    // Estilos extraídos para mantener el código limpio
    const navLinkStyles = ({ isActive }: { isActive: boolean }) =>
        `text-base font-medium px-5 py-2.5 rounded-xl transition-all duration-300 flex items-center gap-2 ${
            isActive
                ? "bg-emerald-500/15 text-emerald-400 shadow-sm"
                : "text-slate-300 hover:bg-slate-800 hover:text-white"
        }`;

    return (
        <nav className="bg-slate-900 border-b border-slate-800 flex justify-between items-center px-8 py-5 shadow-xl sticky top-0 z-50">
            {/* LOGO */}
            <NavLink to={"/"} className="flex items-center gap-3 group">
                <div className="bg-emerald-600/20 p-2.5 rounded-xl text-emerald-500 group-hover:bg-emerald-500/30 transition-colors">
                    <BuildingOfficeIcon className="size-8" />
                </div>
                <h2 className="text-3xl tracking-wide font-extrabold text-white">
                    Hotel<span className="text-emerald-500"> Moron</span>
                </h2>
            </NavLink>

            {/* ENLACES */}
            <ul className="flex items-center gap-4">
                <li>
                    <NavLink to={"/registro"} className={navLinkStyles}>
                        Registrarse
                    </NavLink>
                </li>
                <li>
                    <NavLink to={"/iniciarSesion"} className={navLinkStyles}>
                        Iniciar Sesión
                    </NavLink>
                </li>
            </ul>
        </nav>
    );
}