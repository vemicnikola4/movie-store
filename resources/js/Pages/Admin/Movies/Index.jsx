
import NumberInput from "@/Components/NumberInput";
import PriceInput from "@/Components/PriceInput";
import PrimaryButton from "@/Components/PrimaryButton";
import TextInput from "@/Components/TextInput";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head ,Link, router } from "@inertiajs/react";
import { useState } from "react";


const Index = ({ movies, queryParams,successMessage}) => {
    
    queryParams = queryParams || {};
    successMessage = successMessage || '';
    let sortedBy;
    let direction;
     if (queryParams.sort_by_release_date ){
        sortedBy = 'Sorted by release date';
        direction = queryParams.sort_by_release_date;
     }else if (queryParams.sort_by_price){
        sortedBy = 'Sorted by price';
        direction = queryParams.sort_by_price;


     }else if (queryParams.sort_by_title){
        sortedBy = 'Sorted by title';
        direction = queryParams.sort_by_title;
     }else{
        sortedBy = '';
        direction = '';
     }
    const [selectedOption, setSelectedOption] = useState(
        ''
    )
   
    const searchFildChanged = (name,value)=>{
        if( value ){
            queryParams[name] = value;
        }else{
            delete queryParams[name];
        }
        router.get(route("admin.movie", queryParams));
    }
    const onKeyPress = (name,e)=>{
        if ( e.key !== 'Enter')return;

        searchFildChanged(name, e.target.value);
    }

    

    const handleSubmit = (event)=>{
        event.preventDefault();
        const confirmed = window.confirm("Are you sure you want to update the price?");
        if (confirmed) {
            let data = {
                movie_id: event.target.movie_id.value,
                price: event.target.price.value,
            };
            

            router.post('movie/update', data);
            window.location.reload();
        } else {
            alert("Price update canceled.");
        }
        
    }
    const onValueChange = (value,id)=>{
        movies.forEach((movie)=>{
            if ( movie.id === id){
                movie.price = Number(value);
            }
        })
    }
    const handleSelectChange = (event) => {
        setSelectedOption(event.target.value);

        if ( event.target.value == 'by_price'){
            if ( queryParams.sort_by_release_date ){
                delete queryParams.sort_by_release_date
            }
            if ( queryParams.sort_by_title){
                delete queryParams.sort_by_title;
            }
            if ( queryParams['sort_by_price'] == 'asc'){
                queryParams['sort_by_price'] = 'desc';
            }else{

                queryParams['sort_by_price'] = 'asc';
            }

        }else if(event.target.value == 'by_title'){
            if ( queryParams.sort_by_release_date ){
                delete queryParams.sort_by_release_date
            }
            if ( queryParams.sort_by_price){
                delete queryParams.sort_by_price;
            }
            if ( queryParams['sort_by_title'] == 'asc'){

                queryParams['sort_by_title'] = 'desc';
            }else{

                queryParams['sort_by_title'] = 'asc';
            }
        }else if(event.target.value == 'by_release_date'){
            if ( queryParams.sort_by_price ){
                delete queryParams.sort_by_price
            }
            if ( queryParams.sort_by_title){
                delete queryParams.sort_by_title;
            }
            if ( queryParams['sort_by_release_date'] == 'asc'){

                queryParams['sort_by_release_date'] = 'desc';
            }else{

                queryParams['sort_by_release_date'] = 'asc';
            }
        }
        router.get(route("admin.movie", queryParams));
        
      };
    const onClickDeleteMovie= (e,movieId)=>{
        e.preventDefault();
        const confirmed = window.confirm("Are you sure you want to delete the movie?");
        if (confirmed) {

            queryParams = {};
            queryParams['id'] = movieId;

            router.delete(`movie/delete/${movieId}`);
            setTimeout(()=>{
                router.get(route("admin.movie"));

            },1000)

        } else {
            alert("Movie delete canceled.");
        }

    }
    return <>
        <AuthenticatedLayout
            header={
                <h2 className="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                    Movies
                </h2>
            }
        >
            <Head title="Admin Dashboard" />
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
                                        <th className="px-3 py-3 hover:cursor-pointer">Release date</th>
                                        <th className="px-3 py-3 hover:cursor-pointer">Action</th>
                                    </tr>

                                </thead>
                                <thead className="text-xs text-gray-700  bg-gray-50 dark:bg-gray-700 dark:text-gray-400 border-b-2 border-gray-500">
                                    <tr className="text-nowrap">
                                        <th className="px-3 py-3 hover:cursor-pointer">
                                        </th>
                                        <th className="px-3 py-3 hover:cursor-pointer"></th>
                                        <th className="px-3 py-3 hover:cursor-pointer"><TextInput onBlur={e=>searchFildChanged('title', e.target.value)}onKeyPress={e=>onKeyPress('title',e)} defaultValue={queryParams.title} /></th> 
                                        <th className="px-3 py-3 hover:cursor-pointer"><TextInput onBlur={e=>searchFildChanged('price', e.target.value)} onKeyPress={e=>onKeyPress('price',e)} defaultValue={queryParams.price} />
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

                                        </th>
                                        
                                    </tr>

                                </thead>
                                <tbody>
                                    {movies.length > 0 && 
                                        movies.map((movie,ind) => (
                                            <tr className="bg-white border-b dark:bg-gray-800 dark:border-gray-700" key={ind}>
                                                <td className="px-3 py-2 text-lg color-dark-500">
                                                    {movie.id}
                                                </td>
                                                <td className="px-3 py-2">
                                                    <a href={movie.image_path}>
                                                    <img src={movie.image_path} alt="image" style={{width:100}}/>

                                                    </a>
                                                </td>
                                                <td className="px-3 py-2">
                                                    {movie.title}
                                                </td>
                                                <td className="px-3 py-2" >
                                                    <form onSubmit={handleSubmit}>
                                                        <PriceInput price={movie.price} name={'price'} key={ind} id={movie.id} onValueChange={onValueChange} className="rounded-md"/>
                                                         <input type="hidden" value={movie.id} name={'movie_id'} />
                                                        <button type="submit" className="ml-2 text-blue-600 hover:underline ">Change price</button>
                                                    </form>
                                                    {/* <PrimaryButton onChange={e=>(changeMoviePrice(movie.id,e.target.value))}>Change Price</PrimaryButton> */}
                                                </td>
                                               
                                                <td className="px-3 py-2">
                                                    {movie.release_date}
                                                </td>
                                                <td className="px-3 py-2">
                                                    <div className="grid xl:grid-cols-3 gap-1">
                                                        <Link href={route('admin.get_people', movie.id)} className={ "font-medium text-center text-blue-600 hover:underline mx-1 " + (movie.people.length > 0 ? " text-gray-600 cursor-default hover:no-underline " : "")}>
                                                            Add people
                                                        </Link>
                                                    </div>
                                                    <div className="grid xl:grid-cols-3 gap-1">
                                                        <span className={ "font-medium text-center text-red-600 hover:underline hover:cursor-pointer mx-1 " } onClick={e=>onClickDeleteMovie(e,movie.id)}>
                                                            Delete
                                                        </span>
                                                    </div>
                                                    <div className="grid xl:grid-cols-3 gap-1">
                                                    <Link href={`/admin/movie/show/${movie.id}`} className={ "font-medium text-center text-green-600 hover:underline mx-1 " }>
                                                            Details
                                                        </Link>
                                                    </div>

                                                </td>
                                            </tr>
                                        ))

                                        
                                    }

                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </AuthenticatedLayout>



    </>
}
export default Index;
