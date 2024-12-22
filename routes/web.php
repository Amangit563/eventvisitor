<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\TicketscannController;


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
    return view('Login');
});

Route::post('/login', [UserController::class, 'login'])->name('login');

Route::get('/scannticket', function(){
    return view('Admin Report.ScannTicketReport');
});

// Route::get('/usercreatepage', function(){
//     return view('CreateUser');
// });

Route::get('/usercreatepage', [UserController::class, 'getUserCreatePage'])->name('usercreatepage');

Route::post('/register', [UserController::class, 'register'])->name('register');

Route::get('/gettickets', [TicketscannController::class, 'getAllTickets'])->name('gettickets');

Route::get('/manageUser', [UserController::class, 'userDetail'])->name('manageUser');

Route::post('/updatePassword', [UserController::class, 'updatePassword'])->name('updatePassword');

// User Status Update
Route::post('/userStatus', [userController::class, 'userstatus'])->name('userStatus');

// User Delete
Route::delete('/user/{id}', [userController::class, 'destroy'])->name('user.destroy');



Route::get('/get-username-password/{id}', [UserController::class, 'getUserNamePassword']);