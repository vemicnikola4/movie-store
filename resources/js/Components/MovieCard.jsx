import { usePage } from "@inertiajs/react";

const MovieCard = ({ movie , addToCart}) => {
  const user = usePage().props.auth.user;

  const onAddToCartClick = (movieId)=>{
    addToCart(movieId);
  }
  let discounted;
    if (movie.discount > 0) {
      discounted = movie.price - ((movie.price / 100) * movie.discount)
      movie.discountedPrice = discounted.toFixed(1);
  }
  return (
    <div className="min-w-[200px] block mt-4 md:mt-1 bg-gray-300 shadow-lg shadow-white rounded-lg relative h-full">
      <div className="w-full">
        <img
          className="w-full object-cover  rounded-t-lg h-40"
          src={movie.image_path}
          alt={movie.title}
        />
      </div>


      <div className="w-full p-3 ">
        <div className="grid grid-cols-2 gap-3">
          <h2 className="text-xl font-bold hover:underline hover:text-sky-800">
            <a href={user ? route('user.movie.show', movie.id) :  route('movie.show', movie.id)}>
              {movie.title}
            </a>
          </h2>
          <div className="p-2">
            <div className="p-2">
              <div className="rounded-full bg-sky-800 text-center p-2 relative right-0 text-white">6</div>
            </div>
          </div>
          

        </div>
        <div className="py-2">
          {movie.release_date}
        </div>
        <div className="grid grid-cols-2 py-2">
         { 
         movie.genres &&
          movie.genres.map((genre, ind)=> (
            <div key={ind}>
                <div className="hidden lg:block border p-1 text-align-middle rounded-full bg-gray-900 text-xs text-center text-white w-20">
              {genre.name}
            </div>
            </div>

            
          ))
        }
        </div>
        <div className="h-32 overflow-y-auto mb-3 border-b-2">
          {movie.overview}
        </div>
        <div className="grid grid-cols-2 gap-4 absolute bottom-0 left-0 pt-3 bg-gradient-to-b from-gray-300 to-gray-500 m-3 rounded-md">
          <div className="p-1 ">
            {
              user ? 
              <button className="text-white p-2 bg bg-sky-800 text-sm rounded-lg hover:bg-sky-600" onClick={e=>(onAddToCartClick(movie.id))}>Add to cart</button>
              :
              <button className="text-white p-2 bg bg-sky-800 text-sm rounded-lg hover:bg-sky-600 m-2">
                <a href="/user/movie">Add to cart</a></button>
            }
            
          </div>
          <div className="text-red-700 font-extrabold ">
            {movie.price}
            {
              discounted && 
              <div className="text-green-900 font-extrabold">{movie.discountedPrice}</div>
            }
          </div>
        </div>
        

          {/* <div className="w-full">
            <div className="p-6">
              <div className="w-32 rounded-full bg-emerald-700 text-center p-6">6</div>
            </div>
            <div className="">
              <button className="text-white p-2 bg bg-blue-500 text-sm rounded-lg">Add to cart</button>
            </div>
          </div> */}

      </div>
    </div>
  );
};

export default MovieCard;