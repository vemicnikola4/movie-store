
import DiscountInput from "@/Components/DiscountInput";
import NumberInput from "@/Components/NumberInput";
import PriceInput from "@/Components/PriceInput";
import Pagination from "@/Components/Pagination";
import TextInput from "@/Components/TextInput";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, Link, router } from "@inertiajs/react";
import { useState } from "react";

//podsetnik :
//Dodaj polje da se onese popust
//Dodaj polje koje pokazuje na koji nacin su filtirani filmovi.
const Index = ({ paginator, queryParams, successMessage }) => {
    let movies = paginator.data;
    queryParams = queryParams || {};
    successMessage = successMessage || '';
    let sortedBy;
    let direction;
    const [massDiscount, setMassDiscount] = useState(0);


    const massDiscountChange = (e) => {
        if (e.target.value > 100) {
            setMassDiscount(100)
        } else if (e.target.value < 0) {
            setMassDiscount(0)

        } else {
            setMassDiscount(e.target.value);

        }
    }
    const handleMassDiscountSubmit = (e) => {
        e.preventDefault();
        const confirmed = window.confirm("Are you sure you want to update the price?");
        if (confirmed) {
            let movieIds = [];
            movies.forEach(movie => {
                if (movie.massChecked) {
                    movieIds.push(movie.id);

                }
            })
            let discount;
            if (e.target.massDiscountInput.value == 0) {
                discount = null;
            } else {
                discount = e.target.massDiscountInput.value;
            }
            let data = {
                'movie_id': movieIds,
                'discount': discount
            }
            router.post('movie/update', data);
            window.location.reload();

        } else {
            alert("Price update canceled.");

        }
    }

    
    const [selectedOption, setSelectedOption] = useState(
        ''
    )

    const searchFildChanged = (name, value) => {
        if (queryParams.page) {
            delete queryParams.page;
        }
        if (value) {
            queryParams[name] = value;
        } else {
            delete queryParams[name];
        }
        router.get(route("admin.movie", queryParams));
    }
    const onKeyPress = (name, e) => {
        if (e.key !== 'Enter') return;

        searchFildChanged(name, e.target.value);
    }



    const handlePriceSubmit = (event) => {
        event.preventDefault();
        const confirmed = window.confirm("Are you sure you want to update the price?");
        if (confirmed) {
            let movieId = event.target.movie_id.value;
            let discount;
            movies.forEach((movie) => {
                if (movie.id == movieId) {
                    discount = movie.discount;
                }
            })
            let data = {
                movie_id: movieId,
                price: event.target.price.value,
                discount: discount,
            };


            router.post('movie/update', data);
            window.location.reload();
        } else {
            alert("Price update canceled.");
        }

    }
    const onValueChange = (value, id) => {
        movies.forEach((movie) => {
            if (movie.id === id) {
                movie.price = Number(value);
            }
        })
    }
    const handleSelectChange = (event) => {
        setSelectedOption(event.target.value);

        if (queryParams.page) {
            delete queryParams.page;
        }
        if (event.target.value == 'by_price') {
            if (queryParams.sort_by_release_date) {
                delete queryParams.sort_by_release_date
            }
            if (queryParams.sort_by_title) {
                delete queryParams.sort_by_title;
            }
            if (queryParams['sort_by_price'] == 'asc') {
                queryParams['sort_by_price'] = 'desc';
            } else {

                queryParams['sort_by_price'] = 'asc';
            }

        } else if (event.target.value == 'by_title') {
            if (queryParams.sort_by_release_date) {
                delete queryParams.sort_by_release_date
            }
            if (queryParams.sort_by_price) {
                delete queryParams.sort_by_price;
            }
            if (queryParams['sort_by_title'] == 'asc') {

                queryParams['sort_by_title'] = 'desc';
            } else {

                queryParams['sort_by_title'] = 'asc';
            }
        } else if (event.target.value == 'by_release_date') {
            if (queryParams.sort_by_price) {
                delete queryParams.sort_by_price
            }
            if (queryParams.sort_by_title) {
                delete queryParams.sort_by_title;
            }
            if (queryParams['sort_by_release_date'] == 'asc') {

                queryParams['sort_by_release_date'] = 'desc';
            } else {

                queryParams['sort_by_release_date'] = 'asc';
            }
        }
        router.get(route("admin.movie", queryParams));

    }

    const handleDiscountSubmit = (event) => {
        event.preventDefault();
        const confirmed = window.confirm("Are you sure you want to update the price?");
        if (confirmed) {
            let movieId = event.target.movie_id.value;
            let price;
            movies.forEach((movie) => {
                if (movie.id == movieId) {
                    price = movie.price;
                }
            })
            let discount;
            if (event.target.discount.value == 0) {
                discount = null;
            } else {
                discount = event.target.discount.value;
            }
            let data = {
                movie_id: movieId,
                price: price,
                discount: discount,
            };


            router.post('movie/update', data);
            window.location.reload();
        } else {
            alert("Price update canceled.");
        }
    }
    const onClickDeleteMovie = (e, movieId) => {
        e.preventDefault();
        const confirmed = window.confirm("Are you sure you want to delete the movie?");
        if (confirmed) {

            queryParams = {};
            queryParams['id'] = movieId;

            router.delete(`movie/delete/${movieId}`);
            setTimeout(() => {
                router.get(route("admin.movie"));

            }, 1000)

        } else {
            alert("Movie delete canceled.");
        }

    }

    const onDiscountChange = (value, id) => {
        if (value <= 100 && value >= 0) {
            let movieId = id.slice(8);
            movies.forEach((movie) => {
                if (movie.id === movieId) {
                    movie.discount = Number(value);
                }
            })
        } 
    }
    const showDiscountedChecked = (e) => {
        if (queryParams.page) {
            delete queryParams.page;
        }

        if (e.target.checked) {
            queryParams['discounted'] = 'only_discounted';
        } else {
            if (queryParams.discounted) {
                delete queryParams.discounted;
            }
        }
        router.get(route("admin.movie", queryParams));

    }
    const massCheckClicked = (movieId, e) => {
        movies.forEach((movie) => {
            if (movie.id == movieId) {
                movie.massChecked = e.target.checked;
            }
        })
        console.log(movies);

    }

    movies.forEach((movie) => {
        if (movie.discount > 0) {
            let discounted = movie.price - ((movie.price / 100) * movie.discount)
            movie.discountedPrice = discounted.toFixed(1);
        }
    })
    
    if (queryParams.sort_by_release_date) {
        sortedBy = 'Sorted by release date';
        direction = queryParams.sort_by_release_date;
    } else if (queryParams.sort_by_price) {
        sortedBy = 'Sorted by price';
        direction = queryParams.sort_by_price;


    } else if (queryParams.sort_by_title) {
        sortedBy = 'Sorted by title';
        direction = queryParams.sort_by_title;
    } else {
        sortedBy = '';
        direction = '';
    }
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
        }

    });
   
    
    return <>
        <AuthenticatedLayout>
            <div className="py-12">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                        <p className="text-green-500 p-3">{successMessage}</p>

                        <div className="p-6 text-gray-900 dark:text-gray-100">
                            <div className="overflow-auto">
                                <table className="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                    <thead className="text-xs text-gray-700  bg-gray-50 dark:bg-gray-700 dark:text-gray-400 border-b-2 border-gray-500">
                                        <tr className="text-nowrap">
                                            <th className="px-3 py-3 hover:cursor-pointer">ID</th>
                                            <th className="px-3 py-3 hover:cursor-pointer">Image</th>
                                            <th className="px-3 py-3 hover:cursor-pointer">Title</th>
                                            <th className="px-3 py-3 hover:cursor-pointer">Price</th>
                                            <th className="px-3 py-3 hover:cursor-pointer">Discount</th>
                                            <th className="px-3 py-3 hover:cursor-pointer">Release date</th>
                                            <th className="px-3 py-3 hover:cursor-pointer">Action</th>
                                        </tr>

                                    </thead>
                                    <thead className="text-xs text-gray-700  bg-gray-50 dark:bg-gray-700 dark:text-gray-400 border-b-2 border-gray-500">
                                        <tr className="text-nowrap">
                                            <th className="px-3 py-3 hover:cursor-pointer">
                                            </th>
                                            <th className="px-3 py-3 hover:cursor-pointer"></th>
                                            <th className="px-3 py-3 hover:cursor-pointer"><TextInput onBlur={e => searchFildChanged('title', e.target.value)} onKeyPress={e => onKeyPress('title', e)} defaultValue={queryParams.title} /></th>
                                            <th className="px-3 py-3 hover:cursor-pointer"><TextInput onBlur={e => searchFildChanged('price', e.target.value)} onKeyPress={e => onKeyPress('price', e)} defaultValue={queryParams.price} />
                                                <select id="options" value={selectedOption} onChange={handleSelectChange} className="rounded-md border-gray-500 ml-2">
                                                    <option value="sort">Sort movies</option>
                                                    <option value="by_price">By price</option>
                                                    <option value="by_release_date">By release date</option>
                                                    <option value="by_title">By title</option>
                                                </select>

                                                {/* <button className="m-3 py-3 hover:cursor-pointer text-blue-500" onClick={e => sortByPrice('asc')}>Sort by price asc</button>
                                                <button className="m-3 py-3 hover:cursor-pointer text-blue-500" onClick={e => sortByPrice('desc')}>Sort by price desc</button> */}
                                            </th>
                                            <th className="px-3 py-3 hover:cursor-pointer" >
                                                <span> {sortedBy}</span>
                                                <span> {direction}</span>

                                            </th>
                                            <th>
                                                <label htmlFor="show_discounted_checkbox">Show only discounted</label>
                                                <input type="checkbox" onChange={e => showDiscountedChecked(e)} name="discounted" id="discountedMoviesCheckbox"
                                                    checked={
                                                        queryParams['discounted'] == 'only_discounted' ? true : false
                                                    }
                                                    className="ml-1"
                                                />
                                            </th>
                                            <th>
                                            </th>


                                        </tr>

                                    </thead>
                                    <thead className="text-xs text-gray-700  bg-gray-50 dark:bg-gray-700 dark:text-gray-400 border-b-2 border-gray-500">
                                        <tr className="text-nowrap">
                                            <th className="px-3 py-3 hover:cursor-pointer" colSpan={3}>
                                                <form onSubmit={handleMassDiscountSubmit}>
                                                    <input type="number" value={massDiscount} onChange={e => { massDiscountChange(e) }} name="massDiscountInput" className="rounded-md b-gray-300" />
                                                    <button type="submit" className="ml-2 text-blue-600 hover:underline ">Add discount for checked</button>
                                                </form>

                                            </th>
                                        </tr>

                                    </thead>
                                    <tbody>
                                        {movies.length > 0 &&
                                            movies.map((movie, ind) => (
                                                <tr className="bg-white border-b dark:bg-gray-800 dark:border-gray-700" key={ind}>
                                                    <td className="px-3 py-2 text-lg color-dark-500">
                                                        {movie.id}
                                                    </td>
                                                    <td className="px-3 py-2">
                                                        <a href={movie.image_path}>
                                                            <img src={movie.image_path} alt="image" style={{ width: 100 }} />

                                                        </a>
                                                    </td>
                                                    <td className="px-3 py-2">
                                                        <a href={`/admin/movie/show/${movie.id}`}>
                                                        {movie.title}

                                                        </a>
                                                    </td>
                                                    <td className="px-3 py-2" >
                                                        <form onSubmit={handlePriceSubmit}>
                                                            <PriceInput price={movie.price} name={'price'} key={ind} id={movie.id} onValueChange={onValueChange} className="rounded-md" />
                                                            <input type="hidden" value={movie.id} name={'movie_id'} />
                                                            <button type="submit" className="ml-2 text-blue-600 hover:underline ">Change price</button>
                                                        </form>
                                                        <div>
                                                            <div className="text-red-500  font-bold underline">
                                                                {
                                                                    (movie.discount > 0 ?
                                                                        `Discounted price: ${movie.discountedPrice}` :
                                                                        'No discount')
                                                                }
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td className="px-3 py-2" >
                                                        {movie.discount == null &&
                                                            <form onSubmit={handleDiscountSubmit}>

                                                                <DiscountInput discount={0} name={'discount'} key={ind} id={`discount${movie.id}`} onDiscountChange={onDiscountChange} className="rounded-md" min={0}
                                                                    max={100} />
                                                                <input type="hidden" value={movie.id} name={'movie_id'} />
                                                                <button type="submit" className="ml-2 text-blue-600 hover:underline ">Add discount</button>
                                                            </form>


                                                        }
                                                        {
                                                            movie.discount !== null &&
                                                            <form onSubmit={handleDiscountSubmit}>
                                                                <DiscountInput discount={movie.discount} name={'discount'} key={ind} id={`discount${movie.id}`} onDiscountChange={onDiscountChange} className="rounded-md" min={0}
                                                                    max={100} />
                                                                <input type="hidden" value={movie.id} name={'movie_id'} />
                                                                <button type="submit" className="ml-2 text-blue-600 hover:underline ">Change discount</button>
                                                            </form>
                                                        }

                                                    </td>
                                                    <td className="px-3 py-2">
                                                        {movie.release_date}
                                                    </td>
                                                    <td className="px-3 py-2">
                                                        <div className="grid xl:grid-cols-3 gap-1">
                                                            {
                                                                movie.credits.length <= 0 &&
                                                                <Link href={route('admin.get_people', movie.id)} className={"font-medium text-center text-blue-600 hover:underline mx-1 " }>
                                                                Import people
                                                            </Link>
                                                            }
                                                            
                                                        </div>
                                                        <div className="grid xl:grid-cols-3 gap-1">
                                                            <span className={"font-medium text-center text-red-600 hover:underline hover:cursor-pointer mx-1 "} onClick={e => onClickDeleteMovie(e, movie.id)}>
                                                                Delete
                                                            </span>
                                                        </div>
                                                        <div className="grid xl:grid-cols-3 gap-1">
                                                            <Link href={`/admin/movie/show/${movie.id}`} className={"font-medium text-center text-green-600 hover:underline mx-1 "}>
                                                                Details
                                                            </Link>
                                                        </div>

                                                        <input type="checkbox" name="massCheck" id="" onChange={e => (massCheckClicked(movie.id, e))} />
                                                    </td>
                                                </tr>
                                            ))


                                        }

                                    </tbody>
                                </table>
                                <Pagination links={paginator.links} queryParams={queryParams} />
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </AuthenticatedLayout>



    </>
}
export default Index;
