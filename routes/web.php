<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DokumenController;
use App\Http\Controllers\HomeController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::group(['middleware' => ['web', 'auth','roles']],function(){
    Route::get('/', [HomeController::class, 'index'])->name('index');
        Route::group(['prefix' => 'profile'], function () {
            Route::get('/', [App\Http\Controllers\ProfileController::class, 'index'])->name('profile');
            Route::match(['get', 'post'], 'change-password', [App\Http\Controllers\ProfileController::class, 'changePassword'])->name('changePasswordProfile');
        });
    
        Route::resource('pelayanan', PelayananController::class);
        Route::resource('jenis-pelayanan', JenisPelayananController::class);
        Route::group(['prefix' => 'dokumen','roles'=>['1']], function () {
            Route::group(['prefix' => 'ajax'], function () {
                Route::get('listDokumen', [App\Http\Controllers\DokumenController::class, 'getAllDokumen'])->name('ajax_getall_dokumen');
                Route::post('ajaxDisableEnableDokumen', [App\Http\Controllers\DokumenController::class, 'ajaxDisableEnableDokumen'])->name('ajax_dokumen_disable_enable');
                Route::post('ajaxDeleteDokumen', [App\Http\Controllers\DokumenController::class, 'ajaxDeleteDokumen'])->name('ajax_dokumen_delete');
            });
    
            Route::get('/', [App\Http\Controllers\DokumenController::class, 'index'])->name('view_dokumen');
            Route::match(['get', 'post'], 'view/{id}', [App\Http\Controllers\DokumenController::class, 'view'])->name('view_detail_dokumen');
            Route::match(['get', 'post'], 'create', [App\Http\Controllers\DokumenController::class, 'create'])->name('create_dokumen');
        });

        Route::group(['prefix' => 'jenis-pelayanan','roles'=>['1']], function () {
            Route::group(['prefix' => 'ajax'], function () {
                Route::get('listJenisPelayanan', [App\Http\Controllers\JenisPelayananController::class, 'getAllJenisPelayanan'])->name('ajax_getall_jenis_pelayanan');
                Route::post('ajaxDisableEnableJenisPelayanan', [App\Http\Controllers\JenisPelayananController::class, 'ajaxDisableEnableJenisPelayanan'])->name('ajax_jenis_pelayanan_disable_enable');
                Route::post('ajaxDeleteJenisPelayanan', [App\Http\Controllers\JenisPelayananController::class, 'ajaxDeleteJenisPelayanan'])->name('ajax_jenis_pelayanan_delete');
            });
    
            Route::get('/', [App\Http\Controllers\JenisPelayananController::class, 'index'])->name('view_jenis_pelayanan');
            Route::match(['get', 'post'], 'view/{id}', [App\Http\Controllers\JenisPelayananController::class, 'view'])->name('view_detail_jenis_pelayanan');
            Route::match(['get', 'post'], 'create', [App\Http\Controllers\JenisPelayananController::class, 'create'])->name('create_jenis_pelayanan');
        });

        Route::group(['prefix' => 'pelayanan','roles'=>['1','2']], function () {
            Route::group(['prefix' => 'ajax'], function () {
                Route::get('listPelayanan', [App\Http\Controllers\PelayananController::class, 'getAllPelayanan'])->name('ajax_getall_pelayanan');
                Route::post('ajaxDisableEnablePelayanan', [App\Http\Controllers\PelayananController::class, 'ajaxDisableEnablePelayanan'])->name('ajax_pelayanan_disable_enable');
                Route::post('ajaxDeletePelayanan', [App\Http\Controllers\PelayananController::class, 'ajaxDeletePelayanan'])->name('ajax_pelayanan_delete');
                Route::post('getNomorPelayanan', [App\Http\Controllers\PelayananController::class, 'getNomorPelayanan'])->name('ajax_nomor_pelayanan');
            });
    
            Route::get('/', [App\Http\Controllers\PelayananController::class, 'index'])->name('view_pelayanan');
            Route::match(['get', 'post'], 'view/{id}', [App\Http\Controllers\PelayananController::class, 'view'])->name('view_detail_pelayanan');
            Route::match(['get', 'post'], 'create', [App\Http\Controllers\PelayananController::class, 'create'])->name('create_pelayanan');
            Route::post('upload-dokumen/{id}', [App\Http\Controllers\PelayananController::class, 'uploadDokumen'])->name('upload_dokumen_pelayan');
        });
        // Route::resource('dokumen', DokumenController::class);
    
        Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    
        Route::group(['prefix' => 'user-manajemen','roles'=>['1']], function () {
            Route::group(['prefix' => 'ajax'], function () {
                Route::get('listUser', [App\Http\Controllers\UserController::class, 'getAllUser'])->name('ajax_getall_user');
                Route::post('ajaxDisableEnableUser', [App\Http\Controllers\UserController::class, 'ajaxDisableEnableUser'])->name('ajax_user_disable_enable');
                Route::post('ajaxDeleteUser', [App\Http\Controllers\UserController::class, 'ajaxDeleteUser'])->name('ajax_user_delete');
            });
    
            Route::get('/', [App\Http\Controllers\UserController::class, 'index'])->name('view_user');
            Route::match(['get', 'post'], 'view/{id}', [App\Http\Controllers\UserController::class, 'view'])->name('view_detail_user');
            Route::match(['get', 'post'], 'create', [App\Http\Controllers\UserController::class, 'create'])->name('create_user');
        });
    
    });
