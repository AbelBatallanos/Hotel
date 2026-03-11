import { useEffect, useState } from "react";
import type{ ThabitacionData } from "../types";
import FormCrearHabitacion from "../components/FormCrearhabitacion";
import useHabitacion from "../hooks/useHabitacion";
import type { ResponseServidorErrors } from "../../../types";
import { useNavigate } from "react-router-dom";


const iniHabitacion = {
    codigo : "",
    capacidad: "",
    descripcion: "",
    imagen : null,
    tipo_habitacion_id : "",
}

export default function CrearHabitacion(){
    const [habitacion, setHabitacion] = useState<ThabitacionData>(iniHabitacion);
    const [preview, setPreview] = useState<string | null>(null);
    const {ObtenerTiposHabitacion, ListTiposHabitaciones, CrearHabitacion, ResponseServer} = useHabitacion();
    const navigate = useNavigate();

    useEffect(()=>{
        const fetchTipos = async () => {
            try {
                const data = await ObtenerTiposHabitacion(); // esperas la promesa
                console.log(data)
            } catch (error) {
                console.error("Error al obtener tipos de habitación:", error);
            }
        };

        fetchTipos();
    }, []);



    const handleChange = (data : React.ChangeEvent<HTMLInputElement | HTMLSelectElement | HTMLTextAreaElement>)=>{
        setHabitacion({...habitacion, [data.target.name]: data.target.value});
    }

    const handleImagenChange = (e: React.ChangeEvent<HTMLInputElement>)=>{
        const file = e.target.files?.[0];
        if (file) {
            setHabitacion({...habitacion, imagen: file});
            // Crea una URL temporal para mostrar la imagen en pantalla
            setPreview(URL.createObjectURL(file)); 
        }
    }

    useEffect(()=>{
        console.log(habitacion);
    },[habitacion])

    const handleSubmit = async(ev: React.FormEvent<HTMLFormElement>)=> {
        ev.preventDefault();
        const formData = new FormData();
        formData.append("codigo", habitacion.codigo);
        formData.append("capacidad", habitacion.capacidad);
        formData.append("descripcion", habitacion.descripcion);
        formData.append("tipo_habitacion_id", habitacion.tipo_habitacion_id);
        if (habitacion.imagen) {
            formData.append("imagen", habitacion.imagen); // aquí va el File
        }
        // console.log(formData.values())
        await CrearHabitacion(formData);

        // if(r) setHabitacion(iniHabitacion);
        console.log("Creando Habitacion");
        setHabitacion(iniHabitacion);
        // setTimeout(()=>{
        //     navigate("/habitaciones", {replace: true})
        // }, 5000)
    }
    return(
        <>
            <div className=" ">
                <FormCrearHabitacion 
                    habitacionData={habitacion} 
                    handleSubmit={handleSubmit} 
                    handleChange={handleChange} 
                    handleImagenChange={handleImagenChange}
                    preview={preview}
                    ListTiposHabitaciones={ListTiposHabitaciones}
                    msg={ResponseServer.msg}
                />

                
            </div>
        </>
        
    );
}