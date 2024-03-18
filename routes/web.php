<?php

use Illuminate\Support\Facades\Route;
Use App\Http\Controllers\Site\SiteController;
Use App\Http\Controllers\Admin\PostController;
Use App\Http\Controllers\Admin\AdminController;
Use App\Http\Controllers\Admin\CategoryController;



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


// Route::get('/', function () {
//     return view('layouts.master');
// });
Route::controller(SiteController::class)->group(function(){
    Route::get('/', 'home');
    Route::get('/post-detail/{id}', 'postDetails')->name('post.detail');
});
/*
    ** Backend Routes ------
*/
// Route::get('/admin/dashboard', function () {
//     return view('index');
// });
Route:: group(['prefix'=>'admin/dashboard'], function(){
    Route::controller(AdminController::class)->group(function(){
        Route::get('/', 'dashboard')->name('admin.dashboard');
    });

    // Route::controller(AdminController::class)->group(function(){
    //     Route::prefix('categories')->group(function(){
    //         Route::get('/', 'index')->name('category.index');
    //         Route::post('/store', 'store')->name('category.store');
    //     });
    // }); 

    Route::controller(CategoryController::class)->group(function(){
        Route::prefix('categories')->group(function(){
            Route::get('/', 'index')->name('category.index');
            Route::post('/store', 'store')->name('category.store');
            Route::post('/update', 'update')->name('category.update');
            Route::post('/delete/{category_id', 'delete')->name('category.delete');
        });
    }); 

    Route::controller(PostController::class)->group(function(){
        Route::prefix('posts')->group(function(){
            Route::get('/', 'index')->name('post.index');
            Route::get('/create', 'update')->name('post.create');
            Route::post('/store', 'store')->name('post.store');
            Route::get('/edit/{id}', 'edit')->name('post.edit');
            Route::post('/update{id}', 'update')->name('post.update');
            Route::get('/delete/{id}', 'delete')->name('post.delete');
        });
    }); 
});


// // Route::prefix('admin')->function>({
//     Route::get('admin/dashboard', AdminController::class, 'dashboard' );
// // });

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
