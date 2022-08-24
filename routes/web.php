<?php

use Illuminate\Support\Facades\Route;

// Frontend
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\LoginController;
use App\Http\Controllers\Frontend\BookingDetailsController;
use App\Http\Controllers\Frontend\UserPaymentController;

// Backend
use App\Http\Controllers\Backend\CounterController;
use App\Http\Controllers\Backend\BusController;
use App\Http\Controllers\Backend\CityController;
use App\Http\Controllers\Backend\SeatController;
use App\Http\Controllers\Backend\BookingController;
use App\Http\Controllers\Backend\TripController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Backend\DriverController;
use App\Http\Controllers\Backend\BusRouteController;
use App\Http\Controllers\Backend\LocationController;
use App\Http\Controllers\Backend\PaymentController;
use App\Http\Controllers\Backend\AdminLoginController  as AdminUserController;


// Frontend
Route::get('/',[HomeController::class,'home'])->name('frontend.home');
Route::get('/reserve/form', [HomeController::class, 'reserveForm'])->name('frontend.reserve');
Route::get('/trip', [HomeController::class, 'showTrip'])->name('frontend.showTrip');
Route::get('/trip/{id}', [HomeController::class, 'bookTrip'])->name('frontend.bookTrip')->middleware('auth');
Route::get('/booking/details',[BookingDetailsController::class,'bookingdetails'])->name('booking.details');


 Route::get('/booking/delete/{id}',[BookingController::class,'cancle'])->name('booking.delete');


//Print
Route::get('/print/view{id}',[BookingDetailsController::class,'viewinfo'])->name('view.info');
// Route::get('/booking/view/{id}', [BookingDetailsController::class,'viewinfo'])->name('view.info');

//UserPayment
Route::get('user/payment/{id}',[UserPaymentController::class,'userpayment'])->name('user.payment');
Route::post('user/payment/store/{id}',[UserPaymentController::class,'store'])->name('user.payment.store');

// Registration & login
Route::get('/user/registration',[LoginController::class,'registration'])->name('user.registration');
Route::post('/user/registration/post',[LoginController::class,'registrationPost'])->name('user.registration.post');
Route::get('/user/login',[LoginController::class,'login'])->name('user.login');
Route::post('/user/do/login',[LoginController::class,'doLogin'])->name('user.do.login');
Route::get('/user/logout',[LoginController::class,'logout'])->name('user.logout');
Route::get('/user/email',[LoginController::class,'email'])->name('user.emailforget');

// Admin Panel
Route::group(['prefix'=>'admin'],function(){

//Admin Login
Route::get('/login',[AdminUserController::class, 'login'])->name('admin.login');
Route::post('/dologin',[AdminUserController::class, 'doLogin'])->name('admin.doLogin');

Route::group(['middleware'=>['auth','admin']],function (){
Route::get('/', function () {
                return view('admin.pages.home');
            })->name('home');

// Admin Logout
Route::get('/logout',[AdminUserController::class,'logout'])->name('admin.logout');

//Dashboard
Route::get ('/dashboard',[AdminController::class,'dashboard'])->name('admin.dashboard');

// Booking List
Route::get('/booking/list', [BookingController::class, 'list'])->name('admin.booking.list');
Route::get('/booking/status/{id}', [BookingController::class,'bookingStatus'])->name('admin.booking.status');

Route::delete('/booking/delete/{id}', [BookingController::class, 'bookingdelete'])->name('admin.booking.delete');


// Passenger List
Route::get('/user/list', [UserController::class, 'list'])->name('passenger');

// Location
Route::get('/location/list', [LocationController::class, 'list'])->name('admin.location');
Route::get('/location/delete/{id}',[LocationController::class, 'locationDelete'])->name('admin.location.delete');
Route::get('/location/edit/{id}',[LocationController::class,'locationEdit'])->name('admin.location.edit');
Route::put('/location/update/{id}',[LocationController::class,'locationUpdate'])->name('admin.location.update');
Route::get('/location/create', [LocationController::class, 'create'])->name('admin.location.create');
Route::post('/location/store', [LocationController::class, 'store'])->name('admin.location.store');

// City
Route::get('/city/list', [CityController::class, 'list'])->name('admin.city');
Route::get('/city/view/{city_id}',[CityController::class, 'cityDetails'])->name('admin.city.details');
Route::get('/city/delete/{city_id}',[CityController::class, 'cityDelete'])->name('admin.city.delete');
Route::get('/city/edit/{id}',[CityController::class,'cityEdit'])->name('admin.city.edit');
Route::put('/city/update/{id}',[CityController::class,'cityUpdate'])->name('admin.city.update');
Route::get('/city/create', [CityController::class, 'create'])->name('admin.city.create');
Route::post('/city/store', [CityController::class, 'store'])->name('admin.city.store');

// Driver
Route::get('/driver/list', [DriverController::class, 'list'])->name('admin.driver');
Route::get('/driver/create', [DriverController::class, 'create'])->name('admin.driver.create');
Route::get('/driver/view/{counter_id}',[DriverController::class, 'driverDetails'])->name('admin.driver.details');
Route::get('/driver/delete/{counter_id}',[DriverController::class, 'driverDelete'])->name('admin.driver.delete');
Route::post('/driver/store', [DriverController::class, 'store'])->name('admin.driver.store');

//Counter
Route::get('/counter/list', [CounterController::class, 'list'])->name('admin.counter');
Route::get('/counter/view/{counter_id}',[CounterController::class, 'counterDetails'])->name('admin.counter.details');
Route::get('/counter/delete/{counter_id}',[CounterController::class, 'counterDelete'])->name('admin.counter.delete');
Route::get('/counter/create', [CounterController::class, 'create'])->name('admin.counter.create');
Route::post('/counter/store', [CounterController::class, 'store'])->name('admin.counter.store');

// Bus
Route::get('/bus/list', [BusController::class, 'list'])->name('admin.bus');
Route::get('/bus/view/{bus_id}',[BusController::class, 'busDetails'])->name('admin.bus.details');
Route::get('/bus/edit/{id}',[BusController::class,'busEdit'])->name('admin.bus.edit');
Route::put('/bus/update/{id}',[BusController::class,'busUpdate'])->name('admin.bus.update');
Route::get('/bus/delete/{bus_id}',[BusController::class, 'busDelete'])->name('admin.bus.delete');
Route::get('/bus/create', [BusController::class, 'create'])->name('admin.bus.create');
Route::post('/bus/store', [BusController::class, 'store'])->name('admin.bus.store');


// BusRoute
Route::get('/busroute', [BusRouteController::class, 'search'])->name('admin.search');
Route::get('/busroute/list', [BusRouteController::class, 'list'])->name('admin.busroute');
Route::get('/busroute/view/{busroute_id}',[BusRouteController::class, 'bus_route_Details'])->name('admin.bus_route.details');
Route::get('/busroute/delete/{busroute_id}',[BusRouteController::class, 'bus_route_Delete'])->name('admin.bus_route.delete');
Route::get('/busroute/create', [BusRouteController::class, 'create'])->name('admin.busroute.create');
Route::post('/busroute/store', [BusRouteController::class, 'store'])->name('admin.busroute.store');

// Seat
Route::get('/seat/list', [SeatController::class, 'list'])->name('admin.seat');
Route::get('/seat/edit/{id}',[SeatController::class,'seatEdit'])->name('admin.seat.edit');
Route::put('/seat/update/{id}',[SeatController::class,'seatUpdate'])->name('admin.seat.update');
Route::get('/seat/delete/{id}',[SeatController::class, 'seatDelete'])->name('admin.seat.delete');
Route::get('/seat/create', [SeatController::class, 'create'])->name('admin.seat.create');
Route::post('/seat/store', [SeatController::class, 'store'])->name('admin.seat.store');

// Available Trips
Route::get('/trip/list',[TripController::class, 'list'])->name('admin.trip');
Route::get('/trip/create',[TripController::class, 'create'])->name('admin.trip.create');
Route::post('/trip/store',[TripController::class, 'store'])->name('admin.trip.store');
Route::get('/trip/edit/{id}', [TripController::class, 'edit'])->name('admin.trip.edit');
Route::put('/trip/update/{id}', [TripController::class, 'update'])->name('admin.trip.update');
Route::delete('/trip/delete/{id}', [TripController::class, 'delete'])->name('admin.trip.delete');

// Payment
Route::get('/payment', [PaymentController::class,'payment'])->name('admin.payment');

});
});