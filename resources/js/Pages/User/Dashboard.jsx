import DashboardMovieCard from "@/Components/DashboardMovieCard";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head } from "@inertiajs/react";
import { useState } from "react";
import Pagination from "@/Components/Pagination";


const Dashboard = ({ lastPurchasse, userReviews, bestSelingMovies }) => {
    userReviews = userReviews || [];
    lastPurchasse = lastPurchasse || null;
    bestSelingMovies = bestSelingMovies || null;
    let movies = [];
    let timeOfPurchase;
    let day;
    let month;
    let hours;
    let year;
    let minutes;
    console.log(userReviews);
    if (lastPurchasse !== null) {
        movies = JSON.parse(lastPurchasse.ordered_items);
        let date = new Date(lastPurchasse.created_at);
        year = date.getFullYear();
        month = date.getMonth();  // Month is 0-based (0 = January, 11 = December)
        day = date.getDate();     // Day of the month
        hours = date.getHours();
        minutes = date.getMinutes();
        timeOfPurchase = date ;
    }
    let purchassedItemsCount = 0;
    movies.forEach(element => {
        purchassedItemsCount += element.count;
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
            <div className=" mx-auto p-4 bg-gray-100 block md:grid grid-cols-2">
                <div className="block ">
                    <div className="p-6">
                        <h2 className="text-2xl font-bold ps-2">Last Purchasse</h2>
                        <div className="space-y-4 mt-4">
                            {lastPurchasse ?
                                <div className="bg-white rounded-lg shadow-md p-4">
                                    <div className=" p-2">Cart id: {lastPurchasse.id}</div>
                                    <div className=" p-2">Cart Total: {lastPurchasse.cart_total} RSD</div>
                                    <div className=" p-2">Number of items: {purchassedItemsCount}</div>
                                    <div className=" p-2">Time of purchasse: {`${day}-${month}-${year} ${hours}:${minutes}`}</div>
                                    <div className="p-3">
                                        <a className="hover:underline hover:text-blue-600" href={`/user/cart/show/${lastPurchasse.id}`}>
                                            See detailes
                                        </a>
                                    </div>
                                </div>


                                :
                                <div>
                                    No purchasses made
                                </div>
                            }



                        </div>



                    </div>
                    <div className="p-6">
                        <h2 className="text-2xl font-bold ps-2">Your Reviews</h2>
                        {
                            userReviews.data.length > 0 ?
                            <div className="space-y-4 mt-4">
                                {userReviews.data.map((review, index) => (
                                    <div key={index} className="bg-white rounded-lg shadow-md p-4">
                                        <div className="flex items-center justify-between">
                                            <h3 className="font-semibold">{review.movie.title}</h3>
                                            <span className="text-yellow-500 font-bold">{review.rating}/10</span>
                                        </div>
                                        <p className="text-gray-600 mt-2">{review.comment}</p>
                                        <p className="text-gray-500 text-sm mt-2">{review.created_at}</p>
                                    </div> 
                                ))}
                                <Pagination links={userReviews.links}  />
    
                            </div>
                            :
                            <div className="p-2">
                                No reviews posted yet
                            </div>
                        }
                        
                    </div>
                </div>
                <div className="block">

                    <div className="p-6">
                    <h2 className="text-2xl font-bold ps-2">Best seller movies</h2>
                    {bestSelingMovies ?
                        <div className="space-y-4 mt-4">
                          
                                    {
                                        bestSelingMovies.map((movie, ind) => (
                                            <div key={ind} className="bg-white rounded-lg shadow-md p-4">
                                               
                                                <div className="block h-fit md:grid grid-cols-5">
                                                    <div className="block md:col-span-2 self-center justify-self-center w-32 ">
                                                        <img src={movie.image_path} alt={movie.title} />

                                                    </div>
                                                    <div className="pt-4 block md:col-span-2">
                                                        <h3 className="font-semibold">{movie.title}</h3>
                                                        <div  className="mt-2 h-32 overflow-y-auto">{movie.overview}</div>
                                                    </div>
                                                    <div className="self-center  m-3  block text-center">
                                                        <a className="p-6 md:p-0 rounded-lg md:bg-inherit text-blue bg-blue-100 md:hover:underline md:hover:text-blue-600" href={route('user.movie.show', movie.id)}>
                                                            See more
                                                        </a>

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


            </div>



        </AuthenticatedLayout>

    </>
}

export default Dashboard;