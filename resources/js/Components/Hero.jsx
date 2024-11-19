import TextInput from "./TextInput";
import { useState } from "react";
import { router } from "@inertiajs/react";


const Hero = ({ queryParams }) => {
  queryParams = queryParams || {};
  let sortedBy;
  let direction;
  let searchedBy;
  let searchedByQuery;
  const [inputValue, setInputValue] = useState({
    value: '',
    searchBy: ''
  });
  const onSearchByInputChange = (value) => {
    setInputValue({ ...inputValue, value: value });
  }
  const onSearchBySelectChange = (value) => {
    setInputValue({ ...inputValue, searchBy: value });

  }
  const searchByBtnClicked = () => {
    queryParams = {};

    queryParams[inputValue.searchBy] = inputValue.value;

    router.get(route("movie.index", queryParams));
  }
  const handleSelectChange = (event) => {
    console.log(event.target.value);

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
    router.get(route("movie.index", queryParams));

  }
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
  if ( queryParams.title){
    searchedBy = 'Searched by title';
    searchedByQuery = queryParams.title;
  }else if ( queryParams.release_date){
    searchedBy = 'Searched by release year';
    searchedByQuery = queryParams.release_date;

    
  }else if ( queryParams.rating ){
    searchedBy = 'Searched by rating';
    searchedByQuery = queryParams.rating;

  }else if ( queryParams.genre ){
    searchedBy = 'Searched by genre';
    searchedByQuery = queryParams.genre;

  }else{
    
    searchedBy = ''
    searchedByQuery = '';
  }
  
  return (
    <section className="relative">
      <div
        className="relative h-[40vh] bg-cover bg-center "
        style={{ backgroundImage: "url('https://cdn.pixabay.com/photo/2016/10/29/01/43/abstract-1779644_1280.png')" }}
      >
        <div className="absolute inset-0 bg-black bg-opacity-60 grid grid-col justify-left items-start text-left text-white p-8">
          <h2 className="hidden md:block text-4xl md:text-6xl font-bold mb-4">Discover Movies</h2>
          <p className="text-lg md:text-xl mb-6">Browse movies available</p>
          <div className="block md:grid grid-flow-row-dense grid-cols-3 grid-rows-3">
            <div className="block md:col-span-2">
              {
               inputValue.searchBy == 'genre' ?
                <select name="searchBy" id="" className="text-black rounded-md md:ml-2" onChange={e => onSearchByInputChange(e.target.value)}>
                  <option value="">Genre</option>
                  <option value="action">Action</option>
                  <option value="adventure">Adventure</option>
                  <option value="animation">Animation</option>
                  <option value="comedy">Comedy</option>
                  <option value="comedy">Crime</option>
                  <option value="drama">Drama</option>
                  <option value="family">Family</option>
                  <option value="fantasy">Fantasy</option>
                  <option value="history">History</option>
                  <option value="horror">Horror</option>
                  <option value="music">Music</option>
                  <option value="mystery">Mystery</option>
                  <option value="science fiction">Science Fiction</option>
                  <option value="thriller">Thriller</option>
                </select>
               :
               <TextInput placeholder={'Search'} className="text-black" value={inputValue.value} onChange={e => onSearchByInputChange(e.target.value)} />
              }
              
              <select name="searchBy" id="" className="text-black rounded-md md:ml-2" onChange={e => onSearchBySelectChange(e.target.value)}>
                <option value="">Search by</option>
                <option value="genre">Genre</option>
                <option value="title">Title</option>
                <option value="rating">Rating</option>
                <option value="release_date">Release year</option>
              </select>
              <input type="button" value="search" className="border border-sky-900 ms-2 p-3 rounded-full hover:cursor-pointer hover:bg-slate-100 text-blue-500" onClick={searchByBtnClicked} />
              <div className="hidden md:block  text-white ">{searchedBy}</div>
              <div className="hidden md:block  text-white ">{searchedByQuery}</div>

            </div>
            <div className="block md:col-span-1 justify-items-end">
              <select name="filter" id="" className="text-black rounded-md md:ml-2" onChange={e => handleSelectChange(e)}>
                <option value="">Sort by</option>
                <option value="by_price">Price</option>
                <option value="by_title">Title</option>
                <option value="by_release_date">Release year</option>
              </select>
              <div className="hidden md:block  text-white">{sortedBy}</div>
              <div className="hidden md:block  text-white">{direction}</div>
            </div>









          </div>

        </div>
      </div>
    </section>
  );
};

export default Hero;