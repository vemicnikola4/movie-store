import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head } from "@inertiajs/react";
const Cart = ({cart})=>{

    let orderedItems =  JSON.parse(cart.ordered_items);
    let date = new Date(cart.created_at);
    let timeOfPurchase = date.toLocaleDateString("en-GB") + " " + date.toLocaleTimeString("en-GB");
    console.log(cart);

    return <>
        <AuthenticatedLayout>
            {/* <Head title={}  /> */}
            
            <div className="py-12">
                <div className="width-full sm:px-6 lg:px-8 text-gray-700 mx-auto max-w-7xl font-bold">
                    <div className="rounded-t-md bg-white shadow shadow-sm p-4 flex gap-2">
                        <div className="rounded-sm bg-white shadow shadow-sm p-2 hover:shadow-md">Cart Id: {cart.id} </div>
                        <div className="rounded-sm bg-white shadow shadow-sm p-2 hover:shadow-md">Time of purchasse: {timeOfPurchase} </div>
                        <div className="rounded-sm bg-white shadow shadow-sm p-2 hover:shadow-md">Total: {cart.cart_total}</div>
                    </div>
                </div>
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-b-lg dark:bg-gray-800">
                        
                       
                        <div className="p-6 text-gray-900 dark:text-gray-100">
                       
                            <div className="overflow-auto">
                                <table className="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                    <thead className="text-xs text-gray-700  bg-gray-50 dark:bg-gray-700 dark:text-gray-400 border-b-2 border-gray-500">
                                        <tr className="text-nowrap">
                                            <th className="px-3 py-3 hover:cursor-pointer">Movie Id</th>
                                            <th className="px-3 py-3 hover:cursor-pointer">Movie Image</th>
                                            <th className="px-3 py-3 hover:cursor-pointer">Movie Title</th>
                                            <th className="px-3 py-3 hover:cursor-pointer">Price</th>
                                            <th className="px-3 py-3 hover:cursor-pointer">Item quantity</th>
                                            <th className="px-3 py-3 hover:cursor-pointer">item Total</th>

                                        </tr>

                                    </thead>
                                    <tbody>
                                        {
                                            orderedItems.map((cartItem, ind)=>(
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
                                                    <td className="px-3 py-2 text-lg color-dark-500">
                                                        {cartItem.price}
                                                    </td>
                                    
                                                    <td className="px-3 py-2 text-lg color-dark-500">
                                                        {cartItem.count}
                                                    </td>
                                                    <td className="px-3 py-2 text-lg color-dark-500">
                                                        {cartItem.count * cartItem.price}
                                                    </td>
                                                  
                                           

                                                </tr>   
                                            ))
                                                
                                        }
                                       
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