<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ApiController;

use App\Http\Middleware\AdminMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;


// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

Route::get('/',function(){
    return redirect('/dashboard');
    });

// Route::middleware(['auth', 'verified'])->group(function () {
//     Route::get('/dashboard',fn()=> Inertia::render('Dashboard'))->name('dashboard');
// });



    Route::prefix('admin')->name('admin.')->group(function () {

       
        Route::get('/dashboard',[AdminController::class,'index'])->name('dashboard');
        Route::get('/get_movies',[ApiController::class,'getMoviesFromApi'])->name('get_movies');

        
        Route::get('/get_people/{movieId}',[ApiController::class,'getPeopleFromApi'])->name('get_people');


        Route::get('/movie',[AdminController::class,'movies'])->name('movie');
        Route::get('/movie/show/{movieId}',[AdminController::class,'movieShow'])->name('movie.show');
        Route::post('/movie/update',[AdminController::class,'movieUpdate'])->name('movie.update');
    })->middleware(['auth', 'verified']);

Route::get('/dashboard', function () {
    
    return Inertia::render('Dashboard');


    if (Auth::check() && Auth::user()->is_admin  == 1){
        return  redirect('admin/dashboard');
    }else{
        return Inertia::render('Dashboard');
    }
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
