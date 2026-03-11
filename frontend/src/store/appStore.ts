import {create} from "zustand"
import type { THabitaciones } from "../features/Habitaciones/types"
import type { TReservacion } from "../types"
import { devtools, persist } from "zustand/middleware"

interface  Hotel {
    habitacionesList: THabitaciones[]
    Reservacion: TReservacion
    insertarHabitacionId: (id: string) => void
    agregarHabitacion: (habitacion: THabitaciones) => void
    limpiarTodo: () => void
    showData: ()=>void
    eliminarHabitacion: (id:string)=>void
    existHabitacion: (idHabitacion:string)=> boolean
}


const useAppStore = create<Hotel>()(
    devtools(
        persist(
            (set, get) => ({
                habitacionesList: [],
                Reservacion: { habitaciones: [] },

                  // agrega solo el id a la reservación
                insertarHabitacionId: (id: string) =>
                  set((state) => ({
                    Reservacion: {
                      habitaciones: [...state.Reservacion.habitaciones, { id }]
                    }
                  })),
        
                // agrega el objeto completo a la lista de habitaciones
                agregarHabitacion: (habitacion: THabitaciones) =>
                  set((state) => ({
                    habitacionesList: [...state.habitacionesList, habitacion]
                  })),
        
                   // limpiar solo la reservación
                // limpiar todo (habitaciones y reservación)
                limpiarTodo: () =>
                    set(() => ({
                    habitacionesList: [],
                    Reservacion: {habitaciones: [] }
                    })),

                showData: ( )=>{
                    console.log("DESDE STOREAPP")
                },
               eliminarHabitacion: (id: string) =>
                    set((state) => ({
                    habitacionesList: state.habitacionesList.filter((h) => h.id !== id)
                    })),

                existHabitacion: (idHabitacion: string) : boolean => {
                      return get().habitacionesList.some(
                        (habitacion) => habitacion.id === idHabitacion
                      );
                    }
            }),
            {
                name: "hotel_moron", // nombre de la key en localStorage 
            }
        )
    )
)


export default useAppStore;