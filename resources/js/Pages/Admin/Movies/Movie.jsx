import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head ,Link, router } from "@inertiajs/react";



const Movie = ({movie})=>{

    const dummyReviews = [
        {
          author: "John Doe",
          content: "Inception is a mind-bending thriller that will keep you on the edge of your seat. The visuals are stunning and the story is incredibly well crafted.",
          date: "2021-07-20",
          rating: 9,
        },
        {
          author: "Jane Smith",
          content: "A cinematic masterpiece! The performances and direction are top-notch. Highly recommend for anyone who loves a good sci-fi film.",
          date: "2021-08-15",
          rating: 10,
        },
        {
          author: "Alice Johnson",
          content: "While the movie has some pacing issues, the overall experience is unforgettable. The soundtrack is amazing!",
          date: "2021-09-05",
          rating: 7,
        },
      ];

    
    console.log(movie)
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
                        <span className="text-yellow-500 font-bold">Movie raiting: {movie.rating}</span>
                        
                    </div>
                    <div className="flex items-center mt-2">
                        <span className="text-blue-900 font-bold">Movie Price: {movie.price} RSD</span>
                    </div>
                    <div className="flex items-center mt-2">
                        <span className="text-red-900 font-bold">Number of purchasses: / </span>
                    </div>
                    <div className="flex items-center mt-2">
                        <span className="text-green-900 font-bold">Purchasses Total: / </span>
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
            <div className="p-2">
            <h1 className="text-xl font-bold"><a href="#">See full cast and crew</a></h1>

            </div>

        </div>
        <div className="p-6">
            <h2 className="text-2xl font-bold">Reviews</h2>
            <div className="space-y-4 mt-4">
                {dummyReviews.map((review, index) => (
                <div key={index} className="bg-white rounded-lg shadow-md p-4">
                    <div className="flex items-center justify-between">
                    <h3 className="font-semibold">{review.author}</h3>
                    <span className="text-yellow-500 font-bold">{review.rating}/10</span>
                    </div>
                    <p className="text-gray-600 mt-2">{review.content}</p>
                    <p className="text-gray-500 text-sm mt-2">{review.date}</p>
                </div>
                ))}
            </div>
        </div>
        
       

    </AuthenticatedLayout>
    
    </>
}


export default Movie;