import DashboardMovieCard from "@/Components/DashboardMovieCard";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head } from "@inertiajs/react";
import { useState } from "react";
import Pagination from "@/Components/Pagination";


const Dashboard = ({ lastPurchasse, userReviews, userCarts, user }) => {
    userReviews = userReviews || [];
    user = user || {};
    lastPurchasse = lastPurchasse || null;
    userCarts = userCarts || [];
    let movies = [];
    let timeOfPurchase;
    let day;
    let month;
    let hours;
    let year;
    let minutes;
    console.log(user);
    if (lastPurchasse !== null) {
        movies = JSON.parse(lastPurchasse.ordered_items);
        let date = new Date(lastPurchasse.created_at);
        year = date.getFullYear();
        month = date.getMonth();  // Month is 0-based (0 = January, 11 = December)
        day = date.getDate();     // Day of the month
        hours = date.getHours();
        minutes = date.getMinutes();
        timeOfPurchase = date;
    }
    let purchassedItemsCount = 0;
    movies.forEach(element => {
        purchassedItemsCount += element.count;
    });
    userCarts.forEach(element => {
        let orderedItems = JSON.parse(element.ordered_items);
        let date = new Date(element.created_at);
        element.time = date.toLocaleDateString("en-GB") + " " + date.toLocaleTimeString("en-GB");
        element.orderedItems = orderedItems;
    });
    userCarts.forEach(cart => {
        let numberOfItemsOrdered = 0;
        cart.orderedItems.forEach((element) => {
            numberOfItemsOrdered += element.count;
        })
        cart.numberOfItemsOrdered = numberOfItemsOrdered;
    });
    return <>
        <AuthenticatedLayout
            header={
                <h2 className="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                    User Info Page
                </h2>
            }
        >
            <Head title="User Dashboard" />
            <div className=" mx-auto p-4 bg-gray-100 block md:grid grid-cols-2">
                <div className="block ">
                    <div className="p-6">
                        <h2 className="text-2xl font-bold ps-2">User Detailes</h2>
                        <div className="space-y-4 mt-4">
                            <div className="bg-white rounded-lg shadow-md p-4">
                                <div className=" p-2">Id: {user.id}</div>
                                <div className=" p-2">Email: {user.email}</div>
                                <div className=" p-2">Name: {user.name} </div>

                            </div>






                        </div>
                    </div>
                    <div className="p-6">
                        <h2 className="text-2xl font-bold ps-2">Last Purchasse</h2>
                        <div className="space-y-4 mt-4">
                            {lastPurchasse ?
                                <div className="bg-white rounded-lg shadow-md p-4">
                                    <div className=" p-2">Cart id: {lastPurchasse.id}</div>
                                    <div className=" p-2">Cart Total: {lastPurchasse.cart_total} RSD</div>
                                    <div className=" p-2">Number of items: {purchassedItemsCount}</div>
                                    <div className=" p-2">Time of purchasse: {`${day}-${month}-${year} ${hours}:${minutes}`}</div>
                                    <a href={`/user/cart/show/${user.id}`}>
                                        <div className="mt-2 ps-2 text-lg text-gray-700 hover:underline">See all purchasses</div>

                                    </a>
                                </div>


                                :
                                <div className="mt-2 ps-2 text-lg text-gray-700">
                                    No purchasses made yet!
                                </div>
                            }



                        </div>



                    </div>

                </div>
                <div className="block">
                    <div className="p-6 overflow-x-auto">
                        <h2 className="text-2xl font-bold ps-2">User purchasses</h2>

                        <div className="space-y-4 mt-4 rounden-full">
                            <table className="w-full text-sm text-center  text-gray-500 dark:text-gray-400">
                                <thead className="text-xs text-gray-700  bg-gray-50 dark:bg-gray-700 dark:text-gray-400 border-b-2 border-gray-500">
                                    <tr className="text-nowrap">
                                        <th className="px-3 py-3 hover:cursor-pointer">Cart ID</th>
                                        <th className=" px-3 py-3 hover:cursor-pointer">Number of items</th>
                                        <th className=" px-3 py-3 hover:cursor-pointer">Time of purchasses</th>
                                        <th className="px-3 py-3 hover:cursor-pointer">Total</th>
                                        <th className="px-3 py-3 hover:cursor-pointer">Action</th>

                                    </tr>

                                </thead>
                                {

                                    userCarts.length > 0 ?
                                        <tbody>


                                            {
                                                userCarts.map((cartItem, ind) => (
                                                    <tr className="bg-white border-b dark:bg-gray-800 dark:border-gray-700" key={ind}>
                                                        <td className="px-3 py-2 text-lg color-dark-500">
                                                            {cartItem.id}
                                                        </td>

                                                        <td className=" px-3 py-2 text-lg color-dark-500">
                                                            {cartItem.numberOfItemsOrdered}
                                                        </td>



                                                        <td className=" px-3 py-2 text-lg color-dark-500">
                                                            {cartItem.time}
                                                        </td>
                                                        <td className="px-3 py-2 text-lg color-dark-500">
                                                            {cartItem.cart_total}
                                                        </td>


                                                        <td>

                                                            <div className="block text-center p-2">
                                                                <a href={route('admin.cart.show', cartItem.id)} className="text-green-700 font-bold hover:underline">See More</a>

                                                            </div>


                                                        </td>

                                                    </tr>
                                                ))
                                            }
                                            <a href={`/admin/user/carts/${user.id}`}>
                                                <div className="mt-2 ps-2 block text-start text-lg text-gray-700 hover:underline">See all purchasses</div>
                                            </a>

                                        </tbody>


                                        :
                                        <div className="mt-2 ps-2 text-lg text-gray-700">No purchasses yet!</div>
                                }
                            </table>


                        </div>



                    </div>
                    <div className="p-6">
                        <h2 className="text-2xl font-bold ps-2">User Reviews</h2>
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
                                    <Pagination links={userReviews.links} />

                                </div>
                                :
                                <div className="mt-2 ps-2 text-lg text-gray-700">
                                    No reviews posted yet
                                </div>
                        }

                    </div>
                </div>


            </div>



        </AuthenticatedLayout>

    </>
}

export default Dashboard;