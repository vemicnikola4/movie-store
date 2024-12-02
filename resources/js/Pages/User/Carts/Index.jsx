import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { usePage } from "@inertiajs/react";

export default function Index({carts,message}){

    carts = carts || [];
    carts.forEach(element => {
       let orderedItems =  JSON.parse(element.ordered_items);
       let date = new Date(element.created_at);
       element.time = date.toLocaleDateString("en-GB") + " " + date.toLocaleTimeString("en-GB");
       element.orderedItems = orderedItems;
    });
    carts.forEach(cart => {
        let numberOfItemsOrdered = 0;
        cart.orderedItems.forEach((element)=>{
            numberOfItemsOrdered += element.count;
        })
        cart.numberOfItemsOrdered = numberOfItemsOrdered;
     });
    console.log(carts);

    return <>
        <AuthenticatedLayout>
            <div className="py-12">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                        <div className="text-green-900 font-bold p-3">
                        </div>
                        <div className="text-red-900 font-bold p-3">
                        </div>
                       
                        <div className="p-6 text-gray-900 dark:text-gray-100">
                        
                            <div className="overflow-auto">
                                <table className="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                    <thead className="text-xs text-gray-700  bg-gray-50 dark:bg-gray-700 dark:text-gray-400 border-b-2 border-gray-500">
                                        <tr className="text-nowrap">
                                            <th className="px-3 py-3 hover:cursor-pointer">Cart ID</th>
                                            <th className="px-3 py-3 hover:cursor-pointer">Number of items</th>
                                            <th className="px-3 py-3 hover:cursor-pointer">Time of purchasses</th>
                                            <th className="px-3 py-3 hover:cursor-pointer">Total</th>
                                            <th className="px-3 py-3 hover:cursor-pointer">Action</th>

                                        </tr>

                                    </thead>
                                    <tbody>
                                        {
                                            carts &&
                                            carts.map((cartItem, ind) => (
                                                <tr className="bg-white border-b dark:bg-gray-800 dark:border-gray-700" key={ind}>
                                                    <td className="px-3 py-2 text-lg color-dark-500">
                                                        {cartItem.id}
                                                    </td>
                                                    
                                                    <td className="px-3 py-2 text-lg color-dark-500">
                                                        {cartItem.numberOfItemsOrdered}
                                                    </td>

                                                      
                                                    
                                                    <td className="px-3 py-2 text-lg color-dark-500">
                                                        {cartItem.time}
                                                    </td>
                                                    <td className="px-3 py-2 text-lg color-dark-500">
                                                        {cartItem.cart_total}
                                                    </td>
                                                 
                                                   
                                                    <td>
                                                        <div className="grid grid-cols-3 gap-1">

                                                            <div>
                                                                <p className="text-green-700 font-bold hover:text-underlined">See detailes</p>

                                                            </div>
                                                          
                                                        </div>

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