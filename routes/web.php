<?php

use App\Models\Category;

use Maatwebsite\Excel\Facades\Excel;
// use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BendaharaController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\OsisController;
use App\Http\Controllers\DataVoteController;


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


route::get('/', [LoginController::class, 'landing'])->name('landing');

route::get('/login', [LoginController::class, 'halamanlogin'])->name('login');
route::post('/postlogin', [LoginController::class, 'postlogin'])->name('postlogin');


Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Menampilkan form registrasi // Memproses registrasi
// Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');

// Route::post('/postregister', [RegisterController::class, 'register']);

Route::get('/profile/edit', [UserProfileController::class, 'edit'])->name('profile.edit');
Route::put('/profile/update', [UserProfileController::class, 'update'])->name('profile.update');




Route::group(['middleware' => ['auth', 'permission:Home']], function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    route::get('/petunjuk', [HomeController::class, 'petunjuk'])->name('petunjuk');
});





route::get('/table', [AdminController::class, 'table'])->name('table');
route::get('/users', [AdminController::class, 'users'])->name('users');
route::get('/kategoris', [AdminController::class, 'kategoris'])->name('kategoris');
route::get('/roles', [AdminController::class, 'roles'])->name('roles');







Route::group(['middleware' => ['auth', 'permission:User']], function () {

    Route::post('/importbendahara', [BendaharaController::class, 'userImportExcel'])->name('import-bendahara');
    route::get('/user', [BendaharaController::class, 'bendahara'])->name('bendahara');
    Route::delete('/user/{id}/destroy', [BendaharaController::class, 'destroy'])->name('user.destroy');
    route::get('/add-user', [BendaharaController::class, 'create'])->name('add_user');
    Route::post('/user/store', [BendaharaController::class, 'store']);
    Route::get('/user/{id}/edit  ', [BendaharaController::class, 'edit']);
    Route::put('/guruu/{id}', [BendaharaController::class, 'update']);
    Route::get('/user/{id}/detail', [BendaharaController::class, 'showDetail'])->name('user.showDetail');
    Route::post('/switch-role', [BendaharaController::class, 'switchRole'])->name('switchRole');
    Route::post('/import-user', [BendaharaController::class, 'importUser'])->name('import-user');
    Route::get('/download-template-user', [BendaharaController::class, 'downloadTemplateExcel'])->name('download-template-user');
});



Route::group(['middleware' => ['auth', 'permission:Data Calon OSIS']], function () {

    // Route::get('/kategori', [CategoryController::class, 'index']);
    // route::get('/add-kategori', [CategoryController::class, 'create'])->name('add_kategori');
    // Route::post('/kategori/store', [CategoryController::class, 'store']);
    // Route::delete('/kategori/{id}/destroy', [CategoryController::class, 'destroy'])->name('kategori.destroy');
    // Route::get('/kategori/{id}/edit_kategori', [CategoryController::class, 'edit'])->name('kategori.edit');
    // Route::put('/kategori/{id}', [CategoryController::class, 'update'])->name('kategori.update');
    // Route::post('/importkategori', [CategoryController::class, 'kategoriimportexcel'])->name('import-kategori');
    // Route::get('/export-kategori', [CategoryController::class, 'exportkategori'])->name('export-kategori');
    // Route::get('/download-template-kategori', [CategoryController::class, 'downloadTemplateExcel'])->name('download-template-kategori');
    // Route::get('/kategori/{id}/detail', [CategoryController::class, 'showDetail'])->name('kategori.showDetail');


    route::get('/calon-osis', [OsisController::class, 'osis'])->name('calonosis');
    route::get('/add_osis', [OsisController::class, 'add_osis'])->name('add_osis');
    Route::post('/osis/store', [OsisController::class, 'store']);
    Route::delete('/osis/{id}', [OsisController::class, 'destroy'])->name('osis.destroy');
    Route::get('/calonosis/{id}/edit_osis  ', [OsisController::class, 'edit']);
    Route::put('/calonosis/{id}', [OsisController::class, 'update']);
});

Route::group(['middleware' => ['auth', 'permission:Laporan']], function () {

    Route::get('/laporan-polling', [DataVoteController::class, 'viewPolling'])->name('laporan-polling');
    Route::get('/cetaklaporan', [DataVoteController::class, 'cetaklaporan'])->name('cetaklaporan');
    Route::get('/laporan-voted', [DataVoteController::class, 'viewVoted'])->name('laporan-voted');
});

Route::group(['middleware' => ['auth', 'permission:Setting']], function () {

    route::get('/role', [SettingController::class, 'role'])->name('role');
    Route::get('/role/{id}/edit', [SettingController::class, 'edit']);
    Route::put('/role/{id}', [SettingController::class, 'update']);
    Route::get('/add', [SettingController::class, 'create']);
    Route::post('/role/store', [SettingController::class, 'store']);

    Route::get('/setting-waktu', [SettingController::class, 'settingWaktu'])->name('setting-waktu');
    Route::post('/update-waktu', [SettingController::class, 'updateWaktu'])->name('update-waktu');
    Route::post('/store-vote', [SettingController::class, 'storeVote'])->name('store-vote');
    Route::get('/vote', [SettingController::class, 'index'])->name('vote');
});
