import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, Link, router } from "@inertiajs/react";
import Pagination from "@/Components/Pagination";
import TextInput from "@/Components/TextInput";



const Index = ({paginator, queryParams})=>{
    let users = paginator.data;
    queryParams = queryParams || {};
    const searchFildChanged = (name, value) => {
        if (queryParams.page) {
            delete queryParams.page;
        }
        if (value) {
            queryParams[name] = value;
        } else {
            delete queryParams[name];
        }
        router.get(route("admin.user", queryParams));
    }

    const onKeyPress = (name, e) => {
        if (e.key !== 'Enter') return;

        searchFildChanged(name, e.target.value);
    }
    return <>
    <AuthenticatedLayout>
        <div className="py-12">
            <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">

                    <div className="p-6 text-gray-900 dark:text-gray-100">
                        <div className="overflow-auto">
                            <table className="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                <thead className="text-xs text-gray-700  bg-gray-50 dark:bg-gray-700 dark:text-gray-400 border-b-2 border-gray-500">
                                    <tr className="text-nowrap">
                                        <th className="px-3 py-3 hover:cursor-pointer">ID</th>
                                        <th className="px-3 py-3 hover:cursor-pointer">Email</th>
                                        <th className="px-3 py-3 hover:cursor-pointer">Name</th>
                                        <th className="px-3 py-3 hover:cursor-pointer">Number of purchasses</th>
                                        <th className="px-3 py-3 hover:cursor-pointer">Purchasses Total</th>
                                        <th className="px-3 py-3 hover:cursor-pointer">Last Purchasse</th>
                                        <th className="px-3 py-3 hover:cursor-pointer">Action</th>
                                    </tr>

                                </thead>
                                <thead className="text-xs text-gray-700  bg-gray-50 dark:bg-gray-700 dark:text-gray-400 border-b-2 border-gray-500">
                                    <tr className="text-nowrap">
                                        <th className="px-3 py-3 hover:cursor-pointer">ID</th>
                                        <th className="px-3 py-3 hover:cursor-pointer">
                                        <th className="px-3 py-3 hover:cursor-pointer"><TextInput onBlur={e => searchFildChanged('email', e.target.value)} onKeyPress={e => onKeyPress('email', e)} defaultValue={queryParams.email} /></th>
                                        </th>
                                        <th className="px-3 py-3 hover:cursor-pointer"><TextInput onBlur={e => searchFildChanged('name', e.target.value)} onKeyPress={e => onKeyPress('name', e)} defaultValue={queryParams.name} /></th>
                                        <th className="px-3 py-3 hover:cursor-pointer"></th>
                                        <th className="px-3 py-3 hover:cursor-pointer"></th>
                                        <th className="px-3 py-3 hover:cursor-pointer"></th>
                                        <th className="px-3 py-3 hover:cursor-pointer"></th>
                                    </tr>

                                </thead>
                                
                                <tbody>
                                    {users.length > 0 &&
                                        users.map((user, ind) => (
                                            <tr className="bg-white border-b dark:bg-gray-800 dark:border-gray-700" key={ind}>
                                                <td className="px-3 py-2 text-lg color-dark-500">
                                                    {user.id}
                                                </td>
                                                
                                                <td className="px-3 py-2">
                                                    {user.email}
                                                </td>
                                                <td className="px-3 py-2" >
                                                    {user.name}
                                                    
                                                </td>
                                                <td className="px-3 py-2" >
                                                   0
                                                </td>
                                                <td className="px-3 py-2" >
                                                   0
                                                </td>
                                                <td className="px-3 py-2">
                                                    /
                                                </td>
                                                <td className="px-3 py-2">
                                                    
                                                    <div className="grid xl:grid-cols-3 gap-1">
                                                        <Link href='#' className={"font-medium text-center text-green-600 hover:underline mx-1 "}>
                                                            Details
                                                        </Link>
                                                    </div>

                                                </td>
                                            </tr>
                                        ))


                                    }

                                </tbody>
                            </table>
                            <Pagination links={paginator.links}  />
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </AuthenticatedLayout>



</>


}

export default Index;