
const DashboardMovieCard = ({ movie }) => {


    return <>
        <div className="shadow-lg shadow-gray-300 h-full relative h-full">
            <div className="w-full h-2/3 ">
                <img
                    className="w-full object-cover  h-64 rounded-lg"
                    src={movie.image_path}
                    alt={movie.title}
                />
            </div>
            <div className="p-2 bg-white rounded-lg">
               { movie.title }
            </div>
            <div className="p-2 bg-white rounded-lg">
               { movie.price }
            </div>


            



        </div>
    </>
}

export default DashboardMovieCard;