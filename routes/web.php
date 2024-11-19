<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ApiController;
use App\Http\Controllers\MovieController;

use App\Http\Middleware\AdminMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;


Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        return redirect()->route('movie.index');
    });
});

Route::resource('movie', MovieController::class);

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
        }
        return Inertia::render('Dashboard');
        
    })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
