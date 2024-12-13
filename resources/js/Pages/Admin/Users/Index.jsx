import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import Pagination from "@/Components/Pagination";


export default function Index({paginator, queryParams}){

    const users = paginator.data || [];
    queryParams = queryParams || {};

    return<>
    <AuthenticatedLayout>
        {
       
        <div className="py-12">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">

                        <div className="p-6 text-gray-900 dark:text-gray-100">
                            <div className="overflow-auto">
                                <table className="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                    <thead className="text-xs text-gray-700  bg-gray-50 dark:bg-gray-700 dark:text-gray-400 border-b-2 border-gray-500">
                                        <tr className="text-nowrap">
                                            <th className="px-3 py-3 hover:cursor-pointer"></th>

                                            <th className="px-3 py-3 hover:cursor-pointer">Email</th>
                                            <th className="px-3 py-3 hover:cursor-pointer">Name</th>
                                            <th className="px-3 py-3 hover:cursor-pointer">Number of purchasses</th>
                                            <th className="px-3 py-3 hover:cursor-pointer">Purchasses total</th>
                                            <th className="px-3 py-3 hover:cursor-pointer">Action</th>
                                           
                                        </tr>

                                    </thead>
                                  
                                  
                                    <tbody>
                                        { users.length > 0 ?
                                            users.map((user, ind) => (
                                                <tr className="bg-white border-b dark:bg-gray-800 dark:border-gray-700" key={ind}>
                                                    <td className="px-3 py-2 text-lg color-dark-500">
                                                        {ind+1}
                                                    </td>
                                                    <td className="px-3 py-2 text-lg color-dark-500">
                                                        <a href={`/admin/user/dashboard/${user.id}`} className="hover:underline hover:text-blue-500">
                                                            {user.email}

                                                        </a>
                                                    </td>
                                                    <td className="px-3 py-2">
                                                        {user.name}
                                                    </td>
                                                    <td className="px-3 py-2 text-lg color-dark-500">
                                                        {user.carts_count}
                                                    </td>
                                                    <td className="px-3 py-2 text-lg color-dark-500">
                                                        {user.carts_total}

                                                    </td>
                                                    
                                                    
                                                    <td className="px-3 py-2">
                                                        <div className="grid grid-cols-3 gap-1">

                                                            <div>
                                                                <a href={`/admin/user/carts/${user.id}`}className="text-green-700 font-bold hover:underline">See More</a>

                                                            </div>

                                                        </div>

                                                    </td>
                                                    
                                                  
                                                </tr>
                                            ))
                                            :
                                            <div>
                                                There is no users registered
                                            </div>


                                        }

                                    </tbody>
                                </table>
                                <Pagination links={paginator.links} queryParams={queryParams} />
                            </div>
                        </div>

                    </div>
                </div>
            </div>
       
        }
    </AuthenticatedLayout>
    </>
}