

interface IPrimaryButton {
    content : string,
    textColorBtn : string,
    bgButton? : string
}




export function PrimaryButton({content, textColorBtn, bgButton}: IPrimaryButton){
    
    
    
    return(
        <>
            <button type="submit" className={`text-xl ${textColorBtn} ${bgButton} font-bold text-center p-3 mt-5 rounded-2xl cursor-pointer hover:${bgButton}/60 transition-colors`}>
                {content}
            </button>
        </>
    );

}