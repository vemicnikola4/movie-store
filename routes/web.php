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


Route::middleware(AdminMiddleware::class)->group(function () {
   
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard',[AdminController::class,'index'])->name('dashboard');
        Route::get('/get_movies',[ApiController::class,'getMoviesFromApi'])->name('get_movies');

        // Route::get('/get_movies',[ApiController::class,'getMovies'])->name('get_movies');
        // Route::get('/get_genres',[ApiController::class,'getGenres'])->name('get_genres');
        // Route::get('/get_people',[ApiController::class,'getPeople'])->name('get_people');
    });
});

Route::get('/dashboard', function () {
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
