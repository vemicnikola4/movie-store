import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import Movie from "@/Pages/Movie";
import { useState, useEffect } from "react";
import { router ,usePage,useForm} from "@inertiajs/react";

import { TrashIcon, PlusIcon, MinusIcon } from '@heroicons/react/24/solid'

const Cart = ({message, emptyCart,errors}) => {

    message = message || '';
    let error = errors.cart || errors.total || '';
   
    const [cart, setCart] = useState(() => {
        const cart = localStorage.getItem('cart');
        return cart ? JSON.parse(cart) : [] // Parse JSON if stored as a number
    });
    console.log(cart);
    if ( emptyCart ){
        localStorage.removeItem('cart');
    }
    const [newCart, setNewCart] = useState([]);
    let  cartCopy = cart;
    let  cartTotal = 0 ;
    useEffect(() => {
        localStorage.setItem("cart", JSON.stringify(cart));
       
      
    }, [cart]);
    
    cart.forEach((cartItem) => {
        let count = 0;
        if ( cartItem.discountedPrice ){
            cartTotal += Number(cartItem.discountedPrice);

        }else{
            cartTotal += cartItem.price;
        }
        cartCopy.forEach((cartCopyItem) => {
            if (cartItem.id == cartCopyItem.id) {
                count++;
            }
        })
        cartItem.count = count;
        if (!newCart.some(item => item.id === cartItem.id)) {
            setNewCart([...newCart,cartItem]);
        }
    });
  
    useEffect(()=>{
        
    },[newCart]);

    

    

    const emptyCartOnClick = () => {
        const confirmed = window.confirm("Are you sure you want to empty your cart?");

        if (confirmed) {
            localStorage.removeItem('cart'); // Or use localStorage.clear() to clear everything
            window.location.reload();

        } else {
            alert("Empty your cart canceled.");

        }
    }
    const addQuantity = (itemId) => {
        let movie = cart.filter(movie => movie.id == itemId);
        setCart((prevData) => ([
            ...prevData,
            movie[0]]
        ));
        setNewCart((prevCart) => {
            const existingItem = prevCart.find((i) => i.id === itemId);
            if (existingItem) {
              return prevCart.map((i) =>
                i.id === itemId ? { ...i, count: i.count +1 } : i
              );
            } 
        });
       
    }
    const reduceQuantity = (itemId) => {
      
        setNewCart((prevCart) => {
            const existingItem = prevCart.find((i) => i.id === itemId);
            if (existingItem) {
                
              // Increase quantity if item already exists
              return prevCart.map((i) =>
                i.id === itemId ? { ...i, count: i.count - 1 } : i
              );
            }
        });
        setNewCart((prevCart) => {            
          // Increase quantity if item already exists
          return prevCart.filter((item) => item.count > 0);
            
        });
        
         
        let cartCopy = cart;
          for ( let i = 0; i < cartCopy.length ; i++ ){
            if ( cartCopy[i].id == itemId ){
                cartCopy.splice(i,1);
                break;
            }
        }
        localStorage.setItem("cart", JSON.stringify(cartCopy));

       


    }
    const deleteItem= (itemId)=>{
        setCart((prevCart)=>{
            return prevCart.filter((prevCartItem)=>prevCartItem.id !== itemId);
        })
        setNewCart((prevCart) => {            
            // Increase quantity if item already exists
            return prevCart.filter((prevCartItem)=>prevCartItem.id !== itemId);
              
          });
    }
    const storeCart = (cartTotal)=>{
        let payload = {cart:undefined,total:undefined,jsonCart:undefined};
        payload.cart = cart;
        payload.jsonCart = newCart;
        payload.total = Number(cartTotal);

        localStorage.removeItem('cart');

        
        router.post('/user/cart/store', payload);
       window.location.reload();
        
    }
    return <>
        <AuthenticatedLayout>
            <div className="py-12">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                        <div className="text-green-900 font-bold p-3">
                            {message}
                        </div>
                        <div className="text-red-900 font-bold p-3">
                            {error}
                        </div>
                       
                        <div className="p-6 text-gray-900 dark:text-gray-100">
                            <button onClick={e => (emptyCartOnClick())} className=" font-bold text-red-900 border border-red-900 border-solid border-2 p-3 rounded-full bg-gradient-to-r from-red-500 to-red-300  border hover:bg-red-600 hover:cursor-pointer">Empty cart</button>
                            <button onClick={e => (storeCart(cartTotal.toFixed(1)))} className=" font-bold text-green-900 border border-green-900 border-solid border-2 p-3 rounded-full bg-gradient-to-r from-green-500 to-green-300  border hover:bg-green-600 hover:cursor-pointer">	Proceed with purchasse</button>

                            <div className="overflow-auto">
                                <table className="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                    <thead className="text-xs text-gray-700  bg-gray-50 dark:bg-gray-700 dark:text-gray-400 border-b-2 border-gray-500">
                                        <tr className="text-nowrap">
                                            <th className="px-3 py-3 hover:cursor-pointer">ID</th>
                                            <th className="px-3 py-3 hover:cursor-pointer">Image</th>
                                            <th className="px-3 py-3 hover:cursor-pointer">Title</th>
                                            <th className="px-3 py-3 hover:cursor-pointer">Price</th>
                                            <th className="px-3 py-3 hover:cursor-pointer">Quantity</th>
                                            <th className="px-3 py-3 hover:cursor-pointer">Item Total</th>
                                            <th className="px-3 py-3 hover:cursor-pointer">Action</th>

                                        </tr>

                                    </thead>
                                    <tbody>
                                        {
                                            newCart &&
                                            newCart.map((cartItem, ind) => (
                                                <tr className="bg-white border-b dark:bg-gray-800 dark:border-gray-700" key={ind}>
                                                    <td className="px-3 py-2 text-lg color-dark-500">
                                                        {cartItem.id}
                                                    </td>
                                                    <td className="px-3 py-2">
                                                        <a href={cartItem.image_path}>
                                                            <img src={cartItem.image_path} alt="image" style={{ width: 80, height: 80 }} />

                                                        </a>
                                                    </td>
                                                    <td className="px-3 py-2 text-lg color-dark-500">
                                                        {cartItem.title}
                                                    </td>
                                                    <td className={"px-3 py-2 text-lg color-dark-500  font-bold"
                                                        + (cartItem.discount > 0 ?  " text-green-500 " : "")
                                                    }>
                                                        {cartItem.discount ? 
                                                        Number(cartItem.discountedPrice)
                                                        
                                                        :
                                                        cartItem.price
                                                        }
                                                    </td>
                                                    <td className="px-3 py-2 text-lg color-dark-500">
                                                        {cartItem.count}
                                                    </td>
                                                    <td className="px-3 py-2 text-lg color-dark-500">
                                                        {cartItem.discount ? 
                                                         (cartItem.count * Number(cartItem.discountedPrice)).toFixed(1)
                                                        
                                                        :
                                                        cartItem.count * cartItem.price
                                                        }
                                                        
                                                    </td>
                                                    <td>
                                                        <div className="grid grid-cols-3 gap-1">

                                                            <div>
                                                                <PlusIcon className="text-white bg-blue-900 md:max-w-24 hover:cursor-pointer" onClick={e=>(addQuantity(cartItem.id))}/>

                                                            </div>
                                                            <div>
                                                                <MinusIcon className="text-white bg-green-900 md:max-w-24 hover:cursor-pointer" onClick={e=>(reduceQuantity(cartItem.id))}/>

                                                            </div>
                                                            <div>
                                                                <TrashIcon className="text-white bg-red-900 max-w-12 hover:cursor-pointer" onClick={e=>(deleteItem(cartItem.id))} />

                                                            </div>
                                                        </div>

                                                    </td>

                                                </tr>
                                            ))
                                        }
                                        <tr className=" ">
                                            <td className="block md:grid md:grid-cols-2">
                                                <div className="text-xl border border-blue-900 rounded-full p-3 mt-2 text-blue-900 font-bold border-solid border-2 bg-gradient-to-r from-blue-300 to-blue-100">
                                                    Total: {cartTotal.toFixed(1)}
                                                </div>
                                               
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </AuthenticatedLayout>
    </>
}

export default Cart;