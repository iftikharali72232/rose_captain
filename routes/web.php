
<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\LangController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\User;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\WalletController;

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
// Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::get('lang/{locale}', [LangController::class, 'setLocale'])->name('setLocale');
Route::get('/', function () {
    return redirect()->route('home');
});
// routes/web.php

Route::get('/outh', function () {
    return view('outh');
});
Auth::routes();
Route::group(['middleware' => ['auth']], function() {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::resource('users', User::class);

    Route::resource('companies', CompanyController::class);

    Route::resource('vehicles', VehicleController::class);

    Route::get('/form', [FormController::class, 'create'])->name('form.create');
    Route::post('/form', [FormController::class, 'store'])->name('form.store');

    Route::get('/drivers', [FormController::class, 'drivers'])->name('drivers.index');
    Route::get('/vehicles', [FormController::class, 'vehicles'])->name('vehicles.index');
    Route::get('/companies', [FormController::class, 'companies'])->name('companies.index');
    Route::patch('/drivers/{id}/update-status', [User::class, 'updateStatus'])->name('drivers.update_status');
    Route::resource('wallet', WalletController::class);
    
});

