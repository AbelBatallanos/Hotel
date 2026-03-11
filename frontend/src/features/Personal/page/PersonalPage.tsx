import { useEffect } from "react";
import usePersonal from "../hooks/usePersonal";
import Personal from "../components/Personal";




export default function PersonalPage(){
    const {ObtenerPersonal, PersonalList} = usePersonal();

    useEffect(()=>{
        ObtenerPersonal();
    }, [])


    return(
        <>

            <Personal PersonalList={PersonalList}/>
        </>
    );
}