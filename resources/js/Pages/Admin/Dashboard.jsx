import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head } from "@inertiajs/react";


const Dashboard = ({bestSellerMovie})=>{




    return <>
    <AuthenticatedLayout
    header={
            <h2 className="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Admin dashboard
            </h2>
        }
    >
        <Head title="Admin Dashboard" />
    </AuthenticatedLayout>
        
    </>
}

export default Dashboard;