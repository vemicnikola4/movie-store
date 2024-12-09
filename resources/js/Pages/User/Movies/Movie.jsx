import NumberInput from "@/Components/NumberInput";
import InputLabel from "@/Components/InputLabel";
import InputError from "@/Components/InputError";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, Link, router, usePage } from "@inertiajs/react";
import { useState, useEffect } from "react";
import PrimaryButton from "@/Components/PrimaryButton";
import Pagination from "@/Components/Pagination";


const Movie = ({ movie ,reviewPostedMessage,reviews}) => {
    const user = usePage().props.auth.user;
    reviewPostedMessage = reviewPostedMessage || '';

    let backendErrors = usePage().props.errors;
    console.log(movie);
    
    const [errors, setErrors] = useState({
        text: '',
        rating: ''
    });
    const [cart, setCart] = useState(() => {
        const savedCart = localStorage.getItem("cart");
        return savedCart ? JSON.parse(savedCart) : []; // Parse JSON if stored as a number
    });
    const [review, setReview] = useState({
        text: '',
        rating: ''
    });

    const submit = (e) => {
        e.preventDefault();

        let payload = {

            'comment': review.text,
            'rating': review.rating,
            'movie_id': movie.id,
            'user_id': user.id
        }
        if (review.text && review.rating) {
            if (!errors.text && !errors.rating) {

                router.post('/user/movie/review', payload);

            }
        } else {
            setErrors({ ...errors, text: 'Please enter review!', rating: "PLease enter rating!" });

        }

        // router.post(route('user.review.post', review));
    }

    useEffect(() => {
        localStorage.setItem("cart", JSON.stringify(cart));
    }, [cart]);

    const addToCart = () => {
        setCart((prevData) => ([
            ...prevData,
            movie]
        ));
    };
    const setNumberInputValue = (value) => {
        if (isNaN(value)) {


            setErrors({ ...errors, rating: 'Value must be a number!' });

        } else {
            setErrors({ ...errors, rating: '' });

            setReview({ ...review, rating: Number(value) });

            if (Number(value) > 10 || Number(value) < 1) {
                setErrors({ ...errors, rating: 'Value must be between 1 and 10!' });

            }
        }

    }
    const setReviewText = (e) => {

        setReview({ ...review, text: e.target.value });

        if (e.target.value) {

            setErrors({ ...errors, text: '' });


        } else {

            setErrors({ ...errors, text: "Please enter your review" });

        }
    }


    return <>
        <AuthenticatedLayout>
            <Head title="Movie detailes" />
            <div className="max-w-screen mx-auto p-4 overflow-hidden bg-gray-100">

                <div className="block lg:grid grid-cols-3 gap-0 p-3 px-6">
                    <div className="w-full  ">

                        <img
                            src={movie.image_path}
                            alt={movie.title}
                            className="w-full object-cover object-center rounded-lg shadow-lg "
                        />
                    </div>

                    <div className="md:ml-4 mt-4 md:mt-0 lg:colspan-2 ">
                        <div className="">
                            <h1 className="text-3xl font-bold">{movie.title}</h1>
                            <div className="my-2">
                                <button className="text-white p-2 bg bg-sky-800 text-sm rounded-lg hover:bg-sky-600" onClick={e => (addToCart())}>
                                    Add to cart
                                </button>
                            </div>

                            <p className="text-gray-500">{movie.release_date}</p>
                        </div>
                        <div className="flex items-center mt-2">
                            <span className="text-yellow-500 font-bold">Movie raiting: {movie.rating}</span>

                        </div>

                        <h2 className="mt-4 text-xl font-semibold">Overview</h2>
                        <div className="mt-2 text-gray-700">{movie.overview}</div>
                        <h3 className="mt-4 text-lg font-semibold">Genres</h3>
                        <div className="flex flex-wrap mt-2">
                            {movie.genres.map((genre, index) => (
                                <span key={index} className="bg-blue-500 text-white rounded-full px-3 py-1 m-1">
                                    {genre.name}
                                </span>
                            ))}
                        </div>
                    </div>
                </div>
            </div>
            <div className="p-6 bg-gray-900">
                <h1 className="text-2xl font-bold text-white">Cast</h1>

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
                    <h1 className="text-xl font-bold text-white"><a href="#">See full cast and crew</a></h1>

                </div>

            </div>
            <div className="block md:grid grid-cols-2 gap-2">
                <div className="p-6">
                    <h2 className="text-2xl font-bold">Reviews</h2>
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
                        <Pagination links={reviews.links}  />

                    </div>

                    :
                    <div className="space-y-4 mt-4">
                        <div className="bg-white rounded-lg shadow-md p-4">
                            No reviews posted yet
                        </div>

                    </div>

                    }
                    
                </div>
                <div className="p-6">
                    <h2 className="text-2xl font-bold">Leave your review</h2>
                    <div className={"text-2xl font-bold"
                        + (reviewPostedMessage == 'Review posted successfuly!' ? ' text-green-500 font-bold' : ''
                        )
                        + (reviewPostedMessage == 'You already posted review for this movie!' ? ' text-red-500 font-bold' : ''
                        )
                    } >{reviewPostedMessage}</div>
                    <div className="bg-white shadow-lg p-4 rounded-lg space-y-4 mt-4">

                        <span className={" text-red-500"}>
                            {backendErrors.user_id &&
                                backendErrors.user_id}
                            {backendErrors.movie_id &&
                                backendErrors.movie_id}

                        </span>
                        <form onSubmit={e => submit(e)}>
                            <div className="px-4 ">
                                <InputLabel htmlFor="review" value="Tipe your review" />

                                <textarea
                                    id="review"
                                    type="textarea"
                                    name="review"
                                    value={review.text}
                                    className={"mt-1 block w-full rounded-lg"
                                        + (errors.text.length > 0 ? " border-2 border-red-500" : "")
                                    }
                                    onChange={(e) => setReviewText(e)}
                                />

                                <span className={" text-red-500"}>
                                    {errors.text}
                                </span>
                                <span className={" text-red-500"}>
                                    {backendErrors.comment &&
                                        backendErrors.comment}
                                </span>
                            </div>
                            <div className="px-4">
                                <InputLabel htmlFor="rating" value="Tipe your rating" />

                                <input
                                    id="rating"
                                    type="text"
                                    name="rating"
                                    value={review.rating}
                                    className={"mt-1 block w-full rounded-lg "
                                        + (errors.rating.length > 0 ? " border-2 border-red-500" : "")
                                    }

                                    onChange={(e) => setNumberInputValue(e.target.value)}
                                />
                                <span className={" text-red-500"}>
                                    {errors.rating}
                                </span>
                                <span className={" text-red-500"}>
                                    {backendErrors.rating &&
                                        backendErrors.rating}
                                </span>
                                {/* <InputError  value= message={errors.rating} className="mt-2" /> */}
                            </div>
                            <div className="ms-4 my-2">
                                <PrimaryButton disabled={errors.text || errors.rating ? true : false}>
                                    Post
                                </PrimaryButton>
                            </div>




                        </form>

                    </div>
                </div>
            </div>

        </AuthenticatedLayout>





    </>
}


export default Movie;