import DashboardMovieCard from "@/Components/DashboardMovieCard";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head } from "@inertiajs/react";
import { useState } from "react";


const Dashboard = ({lastPurchasse,reviews,bestSelingMovies})=>{
    reviews = reviews || [];
    lastPurchasse = lastPurchasse || null;
    bestSelingMovies = bestSelingMovies || null;
    let movies = [];
    let timeOfPurchase;
    console.log(bestSelingMovies);
    if ( lastPurchasse !== null ){
        movies = JSON.parse(lastPurchasse.ordered_items);
        let date = new Date(lastPurchasse.created_at);
        timeOfPurchase = date.toLocaleDateString("en-GB") + " " + date.toLocaleTimeString("en-GB");
    }
    let purchassedItemsCount = 0;
    movies.forEach(element => {
        purchassedItemsCount+=element.count;
    });
   
    return <>
    <AuthenticatedLayout
    header={
            <h2 className="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                User Dashboard
            </h2>
        }
    >
        <Head title="User Dashboard" />
        <div className="block md:grid grid-cols-2 gap-2 p-4">
            <div>
                <div className="bg-white shadow-shadow-lg mb-2">
                    <div className=" ps-6 py-3 font-bold text-gray-900 bg-gradient-to-b from-teal-100">
                        <h3>
                        Last Purchasse:

                        </h3>
                    </div>
                    <div className=" p-2 rounded-b-md bg-white shadow-lg">
                        {lastPurchasse ?
                        <>
                        <div className=" p-2">Cart id: {lastPurchasse.id}</div>
                        <div className=" p-2">Cart Total: {lastPurchasse.cart_total} RSD</div>
                        <div className=" p-2">Number of items: {purchassedItemsCount}</div>
                        <div className=" p-2">Time of purchasse: {timeOfPurchase}</div>
                        <div className="p-3">
                            <a className="block bg-gradient-to-b from-teal-100 w-32 p-4 text-gray-900 hover:underline  hover:text-green-700 rounded-full border-2 border-green-300  font-bold hover:underline" href={`/user/cart/show/${lastPurchasse.id}`}>
                                    See detailes
                            </a>
                        </div>
                        </>
                        
                        
                        :
                        <div>
                            No purchasses made
                        </div>
                        }
                        
                        
                        
                    </div>
                    
                    
                    
                </div>
                <div className="bg-white shadow-shadow-lg">

                    <div className=" ps-6 py-3 font-bold text-gray-900 bg-gradient-to-b from-teal-100">
                        <h3 >Your reviews</h3>
                    </div>
                    {
                    reviews.length > 0 ?
                    <div>REviews</div>
                    :
                    <div className="p-2">
                        No reviews posted yet
                    </div> 
                    }
                </div>
            </div>
            <div>
                <div className="bg-white shadow-lg mb-2">
                    <div className=" ps-6 py-3 font-bold text-gray-900 bg-gradient-to-b from-teal-100">

                        <h3 >Best Seling Movies</h3>
                    </div>
                    <div className=" p-2 rounded-b-md bg-white h-96 overflow-y-auto ">
                        {bestSelingMovies ?
                        <table>
                            <thead>
                                <tr className="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <th>Image</th>
                                    <th>Title</th>
                                    <th className="hidden md:table-cell">Overview</th>
                                    <th>Realise date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                {
                                bestSelingMovies.map((movie,ind)=>( 
                                    <tr className="bg-white border-b dark:bg-gray-800 dark:border-gray-700" key={ind}>
                                    
                                    <td className="px-3 py-2">
                                        <a href={movie.image_path}>
                                            <img src={movie.image_path} alt="image" style={{ width: 100 }} />

                                        </a>
                                    </td>
                                    <td className="px-3 py-2">
                                        {movie.title}
                                    </td>
                                    <td className="hidden md:block px-3 py-2">
                                        {movie.overview}
                                    </td>
                                    <td className="px-3 py-2">
                                        {movie.release_date}
                                    </td>
                                    <td className="px-3 py-2 text-gray-900 hover:underline  hover:text-green-700">
                                        <a className="block w-32 p-4 bg-gradient-to-b from-teal-100 rounded-full border-2 border-green-300  font-bold hover:underline text-center" href={route('user.movie.show', movie.id)}>see more</a>
                                    </td>
                                    
                                    
                                </tr>
                                ))
                                }
                            </tbody>
                        </table>
                        :

                        <div>
                            No movies sold yet
                        </div>
                        }
                    </div>
                </div>
            </div>
            

        </div>
        
        
    </AuthenticatedLayout>
        
    </>
}

export default Dashboard;