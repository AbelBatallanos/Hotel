

import { Outlet, Navigate } from "react-router-dom";
import Navegacion from "./Navegacion";



export default function BaseAuth(){

    return(
        <>
            <Navegacion />
            <Outlet />
        
        </>
    );

}