<?php

use App\Models\Category;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HouseController;
use App\Models\House;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    $categories = Category::all();
    $houses = House::with(['category', 'photos'])->paginate(6); // Carga anticipada de photos y category
    return view('welcome', compact('categories', 'houses'));
})->name("home");

Route::get('/houses/{house}', [HouseController::class, 'show'])->name('houses.show');
