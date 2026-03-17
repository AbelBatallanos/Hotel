import { BrowserRouter, Routes, Route } from "react-router-dom"
import BaseAuth from "./features/Auth/BaseAuth";
// import Inicio from "./features/Home/page/InicioPage";

import  Login from "./features/Auth/pages/Login";
import Registro from "./features/Auth/pages/Registro";
import BaseInterfaz from "./layout/BaseInterfaz";
import IndexHabitacionesPage from "./features/Habitaciones/page/IndexHabitacionesPage";
import CrearHabitacion from "./features/Habitaciones/page/CrearHabitacionPage";
import EditarHabitacion from "./features/Habitaciones/page/EdithabitacionPage";import PersonalPage from "./features/Personal/page/PersonalPage";
import RegistrarPersonalPage from "./features/Personal/page/RegistrarPersonalPage";
import MisReservasPage from "./features/Reservas/pages/MisReservasPage";
import CrearReserva from "./features/Reservas/pages/CrearReserva";
import ReservacionesPage from "./features/Reservas/pages/ReservacionesPage";




export default function AppRoutes(){

    return(
        <BrowserRouter>
            <Routes>
                <Route element={<BaseAuth/>}> 
                    {/* <Route path="/" element={ <Inicio/>  } index />  */}
                    <Route path="/iniciarsesion" element={<Login/> } index/>
                    <Route path="/registro" element={<Registro/> }/>
                </Route>

                <Route element={<BaseInterfaz/>}>
                    {/* RESERVACIONES (EL "CARRITO" Y EL HISTORIAL) */}
                    <Route path="/misreservaciones" element={<MisReservasPage />} />
                    {/* <Route path="/favoritos" element={<MisReservasPage />} /> */}
                    <Route path="/reservas/nueva" element={<CrearReserva />} /> 
                    {/* <Route path="/reservas/:id/factura" element={<FacturaPage />} /> */}
                    <Route path="/reservaciones" element={<ReservacionesPage/>}>          
                    </Route>
                    <Route path="/reservacion/:id/confirmacion" element={<ReservacionesPage/>}></Route>
                  
                  
                  {/* HABITACIONES */}
                    <Route path="/habitaciones" element={<IndexHabitacionesPage />} />
                    <Route path="/habitaciones/nueva" element={<CrearHabitacion />} />
                    <Route path="/habitaciones/:id/editar" element={<EditarHabitacion />} />
                    
                    <Route path="/generar/factura/reservacion"></Route>
                    <Route path="/editar/factura/reservacion"></Route>

                    <Route path="/personal" element={<PersonalPage />}></Route>
                    <Route path="/personal/nuevo" element={<RegistrarPersonalPage />}></Route>

                </Route>

            </Routes>
        </BrowserRouter>
    );

}