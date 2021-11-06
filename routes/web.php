<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\Ip;
use App\Models\Label;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('home');

Route::get('/dashboard/{id?}', function ($id = 0) {
    
    if($id){
        $labels = Label::with('user')->where('ip_id', $id)->get();
    } else {
        $labels = null;
    }
    
    return Inertia::render('Dashboard',[
        'ips' => Ip::paginate(),
        'labels' => $labels,
        'current_id' => $id
    ]);
})->name('dashboard');

Route::post('/store',[DashboardController::class, 'store'])->name('store');
Route::put('/update/{id}',[DashboardController::class, 'update'])->name('update');


// Route::get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';
