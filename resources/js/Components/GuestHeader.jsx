import { Link } from "@inertiajs/react";
const GuestHeader = ({cart}) => {


    localStorage.clear();
    return (
        <header className=" flex justify-between items-center px-6 py-1 bg-gray-900 shadow-lg text-white">
            <h1 className="font-bold text-xl">Movie store</h1>
            <div  className="w-full">
            <nav className=" grid grid-cols-4 gap-3">
                <div>
                    <Link
                        href={route('movie.index')}
                        className="hover:underline active:underline
                        p-2 "
                    >
                        Movies
                    </Link>
                    <Link
                        // href={route('cart',cart)}

                        className="hover:underline active:underline
                         p-2"
                    >
                        Cart
                    </Link>
                </div>
                <div>
                    
                </div>
                <div>
                
                </div>
                <div className="grid-cols-2">
                    <Link
                        href={route('login')}
                        className="rounded-md px-3 py-2 text-blue ring-1 ring-transparent transition hover:text-blue/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                    >
                        Log in
                    </Link>
                    <Link
                        href={route('register')}
                        className="rounded-md px-3 py-2 text-blue ring-1 ring-transparent transition hover:text-blue/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                    >
                        Register
                    </Link>
                </div>
                
            </nav>
            </div>
            
        </header>
    );
};

export default GuestHeader;