<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::middleware('auth:api')->get('/', function () {
    return response()->json(['message' => 'Welcome to the home page']);
});
//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
 //   return $request->user();
//});

Route::group(['middleware'=>'api','prefix'=>'auth'],function($router){

    Route::post('/register',[AuthController::class,'register']);
    Route::post('/login',[AuthController::class,'login']);
    Route::get('/profile',[AuthController::class,'profile']);
    Route::post('/logout',[AuthController::class,'logout']);
});

Route::middleware(['role:admin,chefDev'])->get('users',[UserController::class,'index'])->name('index');
Route::get('user', [UserController::class, 'getUser']);
Route::get('/users/edit/{user}', [UserController::class, 'edit'])->name('users.edit');
Route::put('/users/edit/{user}', [UserController::class, 'update'])->name('users.update');

Route::middleware(['role:admin,chefDev'])->get('tasks',[TaskController::class,'index'])->name('index');
Route::get('task/{task}',[TaskController::class,'show'])->name('show');
Route::get('/tasks/assigned',[TaskController::class,'MyTask'])->name('MyTask');
Route::middleware(['role:admin,chefDev'])->get('/tasks/create',[TaskController::class,'create'])->name('create');
Route::middleware(['role:admin,chefDev'])->post('/tasks/create',[TaskController::class,'store'])->name('store');
Route::get('/task/edit/{task}', [TaskController::class, 'edit'])->name('task.edit');
Route::put('/task/edit/{task}', [TaskController::class, 'update'])->name('task.update');
Route::delete('/task/delete/{task}', [TaskController::class, 'destroy'])->name('task.destroy');
Route::get('/task/assign/{task}',[TaskController::class,'assignView'])->name('assignView');
Route::post('/task/assign/{task}',[TaskController::class,'assign'])->name('assign');

Route::post('/task/startTask/{task}',[TaskController::class,'startTask'])->name('startTask');
Route::post('/task/markAsTerminated/{task}',[TaskController::class,'markAsTerminated'])->name('markAsTerminated');
Route::get('notifications',[TaskController::class,'notifications']);
Route::get('notifications/{id}', [TaskController::class, 'showNotification']);
Route::post('notifications/{id}/read', [TaskController::class, 'markAsRead']);

Route::middleware('auth')->post('/messages', [ChatController::class, 'sendMessage']);
Route::middleware('auth')->get('/messages', [ChatController::class, 'getMessages']);















