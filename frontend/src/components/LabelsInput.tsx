





export function LabelsInput({content, forname}: {content : string, forname: string}){
    return (
        <>
            <label form={forname} className="text-gray-400 font-bold block text-xl">
                {content}
            </label>
        </>
    );
}