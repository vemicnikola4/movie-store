import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, Link, router } from "@inertiajs/react";
import Pagination from "@/Components/Pagination";


const Movie = ({ movie, reviews }) => {

    console.log(movie);

    return <>
        <AuthenticatedLayout

        >
            <div className="max-w-screen-lg mx-auto p-4 overflow-hidden">

                <div className="flex flex-col md:flex-row w-100">
                    <img
                        src={movie.image_path}
                        alt={movie.title}
                        className="w-full md:w-1/3 rounded-lg shadow-lg "
                    />
                    <div className="md:ml-4 mt-4 md:mt-0 ">
                        <div className="p-3">
                            <h1 className="text-3xl font-bold">{movie.title}</h1>
                            <p className="text-gray-500">{movie.release_date}</p>
                        </div>
                        <div className="flex items-center mt-2">
                            <span className="text-yellow-500 font-bold">Movie raiting: {movie.rating !== '0,0' ? movie.rating : ' No rating posted yet!'}</span>

                        </div>
                        <div className="flex items-center mt-2">
                            <span className="text-blue-900 font-bold">Movie Price: {movie.price} RSD</span>
                        </div>
                        <div className="flex items-center mt-2">
                            <span className="text-red-900 font-bold">Number of purchasses: {movie.purchasess_count !== '0' ? movie.purchasess_count : ' No purchasess made yet!'}</span>
                        </div>
                        
                        <h2 className="mt-4 text-xl font-semibold">Overview</h2>
                        <p className="mt-2 text-gray-700">{movie.overview}</p>
                        <h3 className="mt-4 text-lg font-semibold">Genres</h3>
                        <div className="flex flex-wrap mt-2">
                            {movie.genres.map((genre, index) => (
                                <span key={index} className="bg-blue-500 text-white rounded-full px-3 py-1 mr-2">
                                    {genre.name}
                                </span>
                            ))}
                        </div>
                    </div>
                </div>
            </div>
            <div className="p-6">
                <h1 className="text-2xl font-bold">Cast</h1>

                <div className="flex overflow-x-auto space-x-4 p-4">
                    {movie.cast.map((person, index) => (

                        (index < 11 ?
                            <div key={index} className="min-w-[200px] bg-white rounded-lg shadow-md overflow-hidden">
                                <img
                                    src={person.image_path}
                                    alt={person.name}
                                    className="w-full h-64 object-cover"
                                />
                                <div className="p-4">
                                    <h3 className="font-semibold">{person.name}</h3>
                                    <p className="font-semibold">{person.character}</p>
                                </div>

                            </div> : null)


                    ))}
                </div>
                

            </div>
            <div className="p-6">
                <h2 className="ps-2 text-2xl font-bold">Reviews</h2>
                {
                    reviews.data.length > 0 ?
                        <div className="space-y-4 mt-4">
                            {reviews.data.map((review, index) => (
                                <div key={index} className="bg-white rounded-lg shadow-md p-4">
                                    <div className="flex items-center justify-between">
                                        <h3 className="font-semibold">{review.user.name}</h3>
                                        <span className="text-yellow-500 font-bold">{review.rating}/10</span>
                                    </div>
                                    <p className="text-gray-600 mt-2">{review.comment}</p>
                                    <p className="text-gray-500 text-sm mt-2">{review.created_at}</p>
                                </div>
                            ))}
                            <Pagination links={reviews.links} />

                        </div>

                        :
                        <div className="space-y-4 mt-4">
                            <div className="bg-white rounded-lg shadow-md p-4">
                                No reviews posted yet
                            </div>

                        </div>

                }

            </div>



        </AuthenticatedLayout>

    </>
}


export default Movie;