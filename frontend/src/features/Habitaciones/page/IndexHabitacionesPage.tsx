import { useEffect, useState } from "react";
import useHabitacion from "../hooks/useHabitacion";
import Habitaciones from "../components/Habitaciones";
import type { THabitaciones } from "../types";

import useAppStore from "../../../store/appStore"
import useLocalStorage from "../../../hooks/useLocalstorage";



export default function IndexHabitaciones(){
    const {ObtenerHabitaciones, HabitacionesData} = useHabitacion();
    const [ReservarHabitacionId, setReservarHabitacionId] = useState<THabitaciones>()
    
    const {agregarHabitacion}= useAppStore();
    const {getDataLocalStorage} = useLocalStorage();
    const usuario = getDataLocalStorage("usuario");
    useEffect(()=>{
        const fetchhabitaciones = async()=>{
            try {
               await ObtenerHabitaciones();
            } catch (error) {
                console.log(error)
            }
        }
        fetchhabitaciones();
    },[])


    const insertarHabitacion = (habitacion: THabitaciones)=>{
        console.log(habitacion);
        agregarHabitacion(habitacion);
    }
    return(
        <> <p>Prueba</p>
            <Habitaciones HabitacionesData={HabitacionesData}
                agregarHabitacion={insertarHabitacion}
                usuario={usuario}
            />
        </>
        
    );
}