import GuestHeader from '@/Components/GuestHeader';
import Hero from '@/Components/Hero';
import MovieCard from '@/Components/Moviecard';
import GuestLayout from '@/Layouts/GuestLayout';
import { Head, Link, usePage } from '@inertiajs/react';
import Pagination from '@/Components/Pagination';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { useState, useEffect } from 'react';

export default function Index({ paginator, queryParams }) {

    queryParams = queryParams || {};
    let moviesByGenres = false;
    let movies;

    const [cart, setCart] = useState(() => {
        const savedCart = localStorage.getItem("cart");
        return savedCart ? JSON.parse(savedCart) : []; // Parse JSON if stored as a number
    });
    useEffect(() => {
        localStorage.setItem("cart", JSON.stringify(cart));
    }, [cart]);
 
    const addToCart = (movieId) => {
        let movie = movies.filter(movie => movie.id == movieId);
        setCart((prevData) => ([
            ...prevData,
            movie[0]]
        ));
    };


    //   useEffect(()=>{
    //     if (localStorage.getItem('cart') !== null) {
    //         console.log(localStorage.getItem('cart'));
    //         // setCart(localStorage.getItem('cart'));
    //     }
    //   },[])

    const handleImageError = () => {
        document
            .getElementById('screenshot-container')
            ?.classList.add('!hidden');
        document.getElementById('docs-card')?.classList.add('!row-span-1');
        document
            .getElementById('docs-card-content')
            ?.classList.add('!flex-row');
        document.getElementById('background')?.classList.add('!hidden');
    };
    if (paginator.data !== undefined) {
        movies = paginator.data;
        paginator.links.forEach((link) => {
            if (link.url) {
                if (queryParams['sort_by_price']) {
                    link.url += `&sort_by_price=${queryParams['sort_by_price']}`;
                } else if (queryParams['sort_by_release_date']) {
                    link.url += `&sort_by_release_date=${queryParams['sort_by_release_date']}`;
                } else if (queryParams['sort_by_title']) {
                    link.url += `&sort_by_title=${queryParams['sort_by_title']}`;
                }
                if (queryParams['price']) {
                    link.url += `&price=${queryParams['price']}`;
                }
                if (queryParams['title']) {
                    link.url += `&title=${queryParams['title']}`;
                }
                if (queryParams['genre']) {
                    link.url += `&genre=${queryParams['genre']}`;
                }
            }

        });
    } else {
        movies = paginator;
        moviesByGenres = {
            action: [],
            comedy: [],
            drama: [],
            horror: [],
            history: [],
            adventure: [],
            thriller: [],
            scienceFiction: []
        }
        movies.forEach((movie) => {
            movie.genres.forEach(genre => {
                if (genre.name == 'Action') {
                    moviesByGenres.action.push(movie);
                }
                if (genre.name == 'Adventure') {
                    moviesByGenres.adventure.push(movie);
                }
                if (genre.name == 'Thriller') {
                    moviesByGenres.thriller.push(movie);
                }
                if (genre.name == 'Horror') {
                    moviesByGenres.horror.push(movie);
                }
                if (genre.name == 'Drama') {
                    moviesByGenres.drama.push(movie);
                }
                if (genre.name == 'Comedy') {
                    moviesByGenres.comedy.push(movie);
                }

            })


        })
    }



    return (
        <>
            <AuthenticatedLayout cart={cart}>
                <Head title="Welcome" />
                <div className=" bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
                    <Hero queryParams={queryParams} />



                    {moviesByGenres ?
                        <div className="p-8  bg-gray-900">
                            {
                                moviesByGenres.action.length > 0 ?
                                    <div className='p-4'>
                                        <h1 className='text-white font-bold text-2xl'>Action</h1>
                                        <div className="flex overflow-x-auto space-x-4 p-4">
                                            {
                                                moviesByGenres.action.map((movie, ind) => (
                                                    <div className="pt-2" key={ind}>
                                                        <MovieCard movie={movie} addToCart={addToCart} />
                                                    </div>
                                                ))
                                            }


                                        </div>
                                        {/* <Pagination links={paginator.links} /> */}

                                    </div>
                                    :
                                    null
                            }
                            {
                                moviesByGenres.thriller.length > 0 ?
                                    <div className='p-4'>
                                        <h1 className='text-white font-bold text-2xl'>Thriller</h1>
                                        <div className="flex overflow-x-auto space-x-4 p-4">
                                            {
                                                moviesByGenres.thriller.map((movie, ind) => (
                                                    <div className="pt-2" key={ind}>
                                                        <MovieCard movie={movie} addToCart={addToCart} />
                                                    </div>
                                                ))
                                            }


                                        </div>
                                        {/* <Pagination links={paginator.links} /> */}

                                    </div>
                                    :
                                    null
                            }
                            {
                                moviesByGenres.adventure.length > 0 ?
                                    <div className='p-4'>
                                        <h1 className='text-white font-bold text-2xl'>Adventure</h1>
                                        <div className="flex overflow-x-auto space-x-4 p-4">
                                            {
                                                moviesByGenres.adventure.map((movie, ind) => (
                                                    <div className="pt-2" key={ind}>
                                                        <MovieCard movie={movie} addToCart={addToCart} />
                                                    </div>
                                                ))
                                            }


                                        </div>
                                        {/* <Pagination links={paginator.links} /> */}

                                    </div>
                                    :
                                    null
                            }
                            {
                                moviesByGenres.horror.length > 0 ?
                                    <div className='p-4'>
                                        <h1 className='text-white font-bold text-2xl'>Horror</h1>
                                        <div className="flex overflow-x-auto space-x-4 p-4">
                                            {
                                                moviesByGenres.horror.map((movie, ind) => (
                                                    <div className="pt-2" key={ind}>
                                                        <MovieCard movie={movie} addToCart={addToCart} />
                                                    </div>
                                                ))
                                            }


                                        </div>
                                        {/* <Pagination links={paginator.links} /> */}

                                    </div>
                                    :
                                    null
                            }
                            {
                                moviesByGenres.drama.length > 0 ?
                                    <div className='p-4'>
                                        <h1 className='text-white font-bold text-2xl'>Drama</h1>
                                        <div className="flex overflow-x-auto space-x-4 p-4">
                                            {
                                                moviesByGenres.drama.map((movie, ind) => (
                                                    <div className="pt-2" key={ind}>
                                                        <MovieCard movie={movie} addToCart={addToCart} />
                                                    </div>
                                                ))
                                            }


                                        </div>
                                        {/* <Pagination links={paginator.links} /> */}

                                    </div>
                                    :
                                    null
                            }
                            {
                                moviesByGenres.comedy.length > 0 ?
                                    <div className='p-4'>
                                        <h1 className='text-white font-bold text-2xl'>Comedy</h1>
                                        <div className="flex overflow-x-auto space-x-4 p-4">
                                            {
                                                moviesByGenres.comedy.map((movie, ind) => (
                                                    <div className="pt-2" key={ind}>
                                                        <MovieCard movie={movie} addToCart={addToCart} />
                                                    </div>
                                                ))
                                            }


                                        </div>
                                        {/* <Pagination links={paginator.links} /> */}

                                    </div>
                                    :
                                    null
                            }


                        </div>
                        :
                        <div className="p-8 bg-gray-900">
                            {
                                movies.length > 0 ?
                                    <div className="block">
                                        <div className="block  md:grid grid-cols-3 lg:grid-cols-5 gap-1 ">
                                            {
                                                movies.map((movie, ind) => (
                                                    <div className="pt-2">
                                                        <MovieCard movie={movie} addToCart={addToCart} />

                                                    </div>

                                                ))
                                            }


                                        </div>
                                        <Pagination links={paginator.links} />

                                    </div>


                                    :
                                    <div className="width-full">
                                        <p className="text-white text-xl">
                                            No movies for your query!
                                        </p>
                                    </div>
                            }
                        </div>
                    }

                </div>
            </AuthenticatedLayout>

        </>




    );
}
