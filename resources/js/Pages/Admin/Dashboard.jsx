import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head } from "@inertiajs/react";


const Dashboard = ({ bestSelingMovies, bestRatedMovies,bestBuyer }) => {



    return <>
        <AuthenticatedLayout
            header={
                <h2 className="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                    Admin dashboard
                </h2>
            }
        >
            <Head title="Admin Dashboard" />
            <div className=" mx-auto p-2 md:p-4 bg-gray-100 block md:grid grid-cols-2">
                <div className="block">
                    <div className="p-2 sm:p-6">
                        <h2 className="text-2xl font-bold ps-2">Best seling movies</h2>
                        {bestSelingMovies ?
                            <div className="space-y-4 overflow-y-auto h-screen  mt-4">

                                {
                                    bestSelingMovies.map((movie, ind) => (
                                        <div key={ind} className="bg-white rounded-lg shadow-md p-4" >

                                            <div className="block md:grid grid-cols-2">
                                                <div className="self-center justify-self-center md:w-4/6 ">
                                                    <img src={movie.image_path} alt={movie.title} />

                                                </div>
                                                <div className="pt-4 block md:p-4 md:ps-1 justify-self-center">
                                                    <a href={route('admin.movie.show', movie.id)}
                                                    >
                                                        <h3 className="font-semibold">{movie.title}</h3>

                                                    </a>
                                                    <div className="hidden md:block mt-2  overflow-y-auto">{movie.overview}</div>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    ))
                                }

                            </div>
                            :
                            <div className="bg-white rounded-lg shadow-md p-4">
                                <div>
                                    No movies sold yet
                                </div>
                            </div>
                        }

                    </div>
                    
                </div>
                <div className="block">
                    
                    <div className="p-6">
                        <h2 className="text-2xl font-bold ps-2">Top Buyer</h2>
                        <div className="space-y-4 mt-4">
                            <div className="bg-white rounded-lg shadow-md p-4">
                                <div className=" p-2">Id: {bestBuyer.id}</div>
                                <div className=" p-2">Email:
                                    <a href={`/admin/user/dashboard/${bestBuyer.id}`} className="hover:underline hover:text-blue-500">
                                         {bestBuyer.email}
                                    </a>
                                </div>
                                
                                <div className=" p-2">Name: {bestBuyer.name} </div>
                                <div className=" p-2">Total: {bestBuyer.carts_total} RSD</div>
                                <div className=" p-2">Number of purchasess: {bestBuyer.purchasess_count} </div>

                            </div>






                        </div>
                    </div>
                </div>
                
            </div>
            <div className="block">
                <div className="p-1 md:p-6">
                        <h2 className="text-2xl font-bold ps-2">Best rated movies</h2>

                    {bestRatedMovies ?
                            <div className="flex overflow-x-auto space-x-4 p-4">
                                {bestRatedMovies.map((movie, ind) => (
                                    <div className="block"  key={ind}>
                                        <div className="bg-white rounded-lg shadow-md p-4 h-full">
                                            <div className="self-center justify-self-center w-32 md:w-64 ">
                                                <img src={movie.image_path} alt={movie.title} />

                                            </div>
                                            <div className="m-2">
                                                <a href={route('admin.movie.show', movie.id)}
                                                >
                                                    <h3 className="font-semibold">{movie.title}</h3>

                                                </a>
                                                <span className="text-yellow-500 font-bold">{movie.rating}/10</span>
                                            </div>
                                        </div>
                                    </div>
                                ))}
                            </div>
                            :
                            <div>
                                No movies rated yet!
                            </div>
                        }
                    </div>
            </div>
           
    </AuthenticatedLayout >

    </>
}

export default Dashboard;