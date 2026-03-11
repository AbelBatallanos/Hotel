


export default function useLocalStorage(){

    const saveDataLocalStorage = ( data : string, nameKey :string) => {
        if(nameKey === "token"){
            localStorage.setItem(nameKey, data);
            return;
        }
        localStorage.setItem(nameKey,  JSON.stringify(data));
    }

    const getDataLocalStorage= ( nameKey : string )=>{
       const contenido = localStorage.getItem(nameKey);
       return contenido ? JSON.parse(contenido) : null;
    }

    const removeDataLocalStorage = (nameKey: string)=> {
        localStorage.removeItem(nameKey);
    }
    return {
        saveDataLocalStorage,
        getDataLocalStorage,
        removeDataLocalStorage
    }
}