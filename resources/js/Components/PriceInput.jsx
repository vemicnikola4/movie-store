import { useState , useEffect} from "react";


const PriceInput = ({price,id,onValueChange,name,})=>{

    const[inputValue,setInputValue] = useState(price);
    const defaultPrice = price;
    const setValue = (e)=>{
        setInputValue(e.target.value);

       
    };
    const setOriginalPrice =()=>{
        setTimeout(()=>{
            setInputValue(defaultPrice);

        },200);

    }
    useEffect(()=>{
        onValueChange(inputValue,id);
    },[inputValue]);



    return <>
    
        <input type="number" className="rounded-md" id={id} value={inputValue} name={name} onChange={e => setValue(e)} onBlur={setOriginalPrice}/>
    </>
}

export default PriceInput;