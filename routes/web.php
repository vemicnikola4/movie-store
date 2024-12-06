<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ApiController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CartController;

use App\Http\Middleware\AdminMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;



Route::middleware('guest')->group(function () {
    
    Route::get('/', function () {
        return redirect()->route('movie.index');
    });
    Route::resource('movie', MovieController::class);

});



// Route::get('movie',function (){
//     if (Auth::check()) {
//         return redirect()->route('user.movie');
//     }
// });
// Route::get('cart',function (Request $request) {
//     return inertia("Cart",[
//         'cart'=>$request['cart'],
        
//     ]);
// })->name('cart');

// Route::get('/',function(){
//     return redirect('/welcome');
// })->middleware(AdminMiddleware::class);

// Route::middleware(['auth', 'verified'])->group(function () {
//     Route::get('/dashboard',fn()=> Inertia::render('Dashboard'))->name('dashboard');
// });

    Route::middleware(['auth', 'verified',AdminMiddleware::class])->group(function () {
        
        Route::prefix('admin')->name('admin.')->group(function () {

       
            Route::get('/dashboard',[AdminController::class,'index'])->name('dashboard');

            //get data from public api
            Route::get('/get_movies',[ApiController::class,'getMoviesFromApi'])->name('get_movies');
            Route::get('/get_people/{movieId}',[ApiController::class,'getPeopleFromApi'])->name('get_people');
    
            //admin movie routes
            Route::get('/movie',[AdminController::class,'movies'])->name('movie');
            Route::get('/movie/show/{movieId}',[AdminController::class,'movieShow'])->name('movie.show');
            Route::post('/movie/update',[AdminController::class,'movieUpdate'])->name('movie.update');
    
            //admin users routes
            Route::get('/user',[AdminController::class,'users'])->name('user');
    
            
        });
    });

   

    Route::get('/dashboard', function () {
        if (Auth::check() && Auth::user()->is_admin == 1) {
            return redirect()->route('admin.dashboard');
        }else if(Auth::check()){
            return redirect()->route('user.dashboard');

        }else{

        }
        
    })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('user')->name('user.')->group(function () {
        Route::get('/movie',[UserController::class, 'movies'])->name('movie');
        Route::get('/movie/show/{id}',[MovieController::class, 'show'])->name('movie.show');
        Route::get('/cart',[UserController::class, 'cart'])->name('cart');
        Route::post('/cart/store',[CartController::class, 'store'])->name('cart.store');
        Route::get('/cart/show/{id}',[CartController::class, 'show'])->name('cart.show');
        Route::get('/dashboard/',[UserController::class, 'dashboard'])->name('dashboard');
        Route::get('/carts/{id}',[UserController::class, 'carts'])->name('carts');
    });
});

require __DIR__.'/auth.php';