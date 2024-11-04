import { useState , useEffect} from "react";


const DiscountInput = ({discount,id,onDiscountChange,name,min,max})=>{

    const[inputValue,setInputValue] = useState(discount);
    const defaultDiscount = discount;
    const setValue = (e)=>{
        if( e.target.value > 100 )
        {
            setInputValue(100);

        }else if( e.target.value < 0 )
        {
            setInputValue(0);

        }else{
            setInputValue(e.target.value);

        }

       
    };
    const setOriginaldiscount =()=>{
        setTimeout(()=>{
            setInputValue(defaultDiscount);

        },200);

    }
    useEffect(()=>{
        onDiscountChange(inputValue,id);
    },[inputValue]);



    return <>
    
        <input type="number" className="rounded-md" id={id} value={inputValue} name={name} onChange={e => setValue(e)} onBlur={setOriginaldiscount} min={min} max={max} /><span className="ml-1">%</span>
    </>
}

export default DiscountInput;