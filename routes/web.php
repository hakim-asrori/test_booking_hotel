<?php

use App\Models\User;
use App\Events\NewReservationEvent;
use App\Events\RefreshDashboardEvent;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\TransactionRoomReservationController;
use App\Http\Controllers\RoomStatusController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogintampilanController;
use App\Http\Controllers\RegistertampilanController;


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



Route::get('tampilan', function (){
    return view('landing/layouts/template');
});

Route::get('tampilan', function (){
    return view('/landing/template');
});

Route::get('/reservation', [ReservationController::class, 'index']);
Route::get('/room-data/{room_id?}', [ReservationController::class, 'roomAjax'])->name('room.data');
Route::post('/reservation/store', [ReservationController::class, 'store'])->name('reservation.store');

Route::get('roomdetail', function (){
    return view('/landing/roomdetail');
});
Route::get('rooms', function (){
    return view('/landing/rooms');
});


Route::prefix("admin")->group(function() {
    Route::resource('type', TypeController::class);
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::post('/room/{room}/image/upload', [ImageController::class, 'store'])->name('image.store');
    Route::resource('roomstatus', RoomStatusController::class);
    Route::name('transaction.reservation.')->group(function () {
        Route::get('/createIdentity', [TransactionRoomReservationController::class, 'createIdentity'])->name('createIdentity');
        Route::get('/pickFromCustomer', [TransactionRoomReservationController::class, 'pickFromCustomer'])->name('pickFromCustomer');
        Route::post('/storeCustomer', [TransactionRoomReservationController::class, 'storeCustomer'])->name('storeCustomer');
        Route::get('/{customer}/viewCountPerson', [TransactionRoomReservationController::class, 'viewCountPerson'])->name('viewCountPerson');
        Route::get('/{customer}/chooseRoom', [TransactionRoomReservationController::class, 'chooseRoom'])->name('chooseRoom');
        Route::get('/{customer}/{room}/{from}/{to}/confirmation', [TransactionRoomReservationController::class, 'confirmation'])->name('confirmation');
        Route::post('/{customer}/{room}/payDownPayment', [TransactionRoomReservationController::class, 'payDownPayment'])->name('payDownPayment');
    });
    Route::resource('transaction', TransactionController::class);
    Route::resource('facility', FacilityController::class);
    Route::resource('customer', CustomerController::class);
    Route::group(['middleware' => ['auth', 'checkRole:Super']], function () {
        Route::resource('user', UserController::class);
    });


});

Route::group(['middleware' => ['auth', 'checkRole:Super,Admin']], function () {

    Route::delete('/image/{image}', [ImageController::class, 'destroy'])->name('image.destroy');

    Route::resource('room', RoomController::class);

    Route::get('/payment', [PaymentController::class, 'index'])->name('payment.index');
    Route::get('/payment/{payment}/invoice', [PaymentController::class, 'invoice'])->name('payment.invoice');

    Route::get('/transaction/{transaction}/payment/create', [PaymentController::class, 'create'])->name('transaction.payment.create');
    Route::post('/transaction/{transaction}/payment/store', [PaymentController::class, 'store'])->name('transaction.payment.store');

    Route::get('/get-dialy-guest-chart-data', [ChartController::class, 'dialyGuestPerMonth']);
    Route::get('/get-dialy-guest/{year}/{month}/{day}', [ChartController::class, 'dialyGuest'])->name('chart.dialyGuest');


});

Route::group(['middleware' => ['auth', 'checkRole:Super,Admin,Customer']], function () {


    Route::view('/notification', 'notification.index')->name('notification.index');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/mark-all-as-read', [NotificationsController::class, 'markAllAsRead'])->name('notification.markAllAsRead');

    Route::get('/notification-to/{id}',[NotificationsController::class, 'routeTo'])->name('notification.routeTo');

    Route::get('/sendEvent', function () {
        $superAdmins = User::where('role', 'Super')->get();
        event(new RefreshDashboardEvent("Someone reserved a room"));

        foreach ($superAdmins as $superAdmin) {
            $message = 'Reservation added by';
            // event(new NewReservationEvent($message, $superAdmin));
        }
    });
});


Route::view('/login', 'auth.login')->name('login');
Route::post('/postLogin', [AuthController::class, 'postLogin'])->name('postlogin');

Route::get('/', [HomeController::class, 'index'])->name('home');

// Login tampilan
Route::post('/app/login', [LogintampilanController::class, 'store']);
Route::get('/logintampilan', [LogintampilanController::class, 'index']);

// Register Tampilan
Route::get('/registertampilan', [RegistertampilanController::class, 'index']);
Route::post('/tampilanregister', [RegistertampilanController::class, 'store']);