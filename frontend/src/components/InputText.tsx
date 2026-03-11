

type InputTextProps = { placeholder: string; type: string; name: string; id: string; requireddata?: boolean; } & React.InputHTMLAttributes<HTMLInputElement>;



export function InputText({placeholder, type, name, id, requireddata,  ...props}: InputTextProps){
    return (
        <>
            <input 
                type={type} 
                name={name} 
                id={id} 
                className="text-gray-600 font-bold text-lg inline-block bg-white w-full p-1 rounded-lg" 
                placeholder={placeholder} 
                required={requireddata}
                {...props}
            />


        </>
    );
}