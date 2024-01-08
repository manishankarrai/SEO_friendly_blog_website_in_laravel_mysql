<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController ;
use App\Http\Controllers\admin\DashboardController ;
use App\Http\Controllers\admin\PostController ;
use App\Http\Controllers\admin\ViralPostController ;
use App\Http\Controllers\admin\CategoryController ;
use App\Http\Controllers\admin\SubCategoryController ;
use App\Http\Controllers\admin\TopicController ;

use App\Http\Controllers\PasswordResetController;

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



Auth::routes();
Route::get('logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

Route::get('/', [HomeController::class, 'index'])->name('index');
Route::get('/home', [HomeController::class, 'index'])->name('home');
//blog routes start
Route::get('/{name}',[HomeController::class , 'getblog'])->name('get-blogs');
//Route::get('/viral/{name}',[HomeController::class , 'getviralblog'])->name('topic-getbyname');
//blog routes start
Route::get('/category/{name}',[HomeController::class , 'getCategoryBySeo'])->name('category-byseo');
Route::get('/tags/{name}',[HomeController::class , 'getSubCategoryBySeo'])->name('subcategory-byseo');

Route::post('/search',[HomeController::class , 'searchpage'])->name('search-page');


Route::group(['middleware'  => ['role:admin|writer']] , function(){
    Route::get('/admin/resetPassword' , [PasswordResetController::class , 'getPage' ])->name('admin-reset-password');
    Route::post('/admin/updatePassword' , [PasswordResetController::class , 'reset' ])->name('admin-update-password');
    Route::get('/admin/dashboard' , [DashboardController::class , 'dashboard' ])->name('admin-dashboard');


  
    
    Route::get('/admin/topic' , [TopicController::class , 'index'])->name('admin-topic');
    Route::get('/admin/topic/create' , [TopicController::class , 'create'])->name('admin-topic-create');
    Route::post('/admin/topic/store' , [TopicController::class , 'store'])->name('admin-topic-store');
    Route::get('/admin/topic/edit/{id}' , [TopicController::class , 'edit'])->name('admin-topic-edit');
    Route::post('/admin/topic/update/{id}' , [TopicController::class , 'update'])->name('admin-topic-update');
    Route::get('/admin/topic/delete/{id}' , [TopicController::class , 'destroy'])->name('admin-topic-delete');

    Route::get('/admin/viralblog' , [ViralPostController::class , 'index'])->name('admin-viralblog');
    Route::get('/admin/viralblog/create' , [ViralPostController::class , 'create'])->name('admin-viralblog-create');
    Route::post('/admin/viralblog/store' , [ViralPostController::class , 'store'])->name('admin-viralblog-store');
    Route::get('/admin/viralblog/edit/{id}' , [ViralPostController::class , 'edit'])->name('admin-viralblog-edit');
    Route::post('/admin/viralblog/update/{id}' , [ViralPostController::class , 'update'])->name('admin-viralblog-update');
    Route::get('/admin/viralblog/delete/{id}' , [ViralPostController::class , 'destroy'])->name('admin-viralblog-delete');
    
    Route::get('/admin/blog' , [PostController::class , 'index'])->name('admin-blog');
    Route::get('/admin/blog/create' , [PostController::class , 'create'])->name('admin-blog-create');
    Route::post('/admin/blog/store' , [PostController::class , 'store'])->name('admin-blog-store');
    Route::get('/admin/blog/edit/{id}' , [PostController::class , 'edit'])->name('admin-blog-edit');
    Route::post('/admin/blog/update/{id}' , [PostController::class , 'update'])->name('admin-blog-update');
    Route::get('/admin/blog/delete/{id}' , [PostController::class , 'destroy'])->name('admin-blog-delete');
    
    //jquery routes
    Route::post('/admin/get/subcategory' , [DashboardController::class , 'getsubcategory'])->name('admin-get-subcategory');
    Route::post('/admin/get/topic' , [DashboardController::class , 'gettopic'])->name('admin-get-topic');


});

Route::group(['middleware'  => ['role:admin']] , function(){

    Route::get('/admin/category' , [CategoryController::class , 'index'])->name('admin-category');
    Route::get('/admin/category/create' , [CategoryController::class , 'create'])->name('admin-category-create');
    Route::post('/admin/category/store' , [CategoryController::class , 'store'])->name('admin-category-store');
    Route::get('/admin/category/edit/{id}' , [CategoryController::class , 'edit'])->name('admin-category-edit');
    Route::post('/admin/category/update/{id}' , [CategoryController::class , 'update'])->name('admin-category-update');
    Route::get('/admin/category/delete/{id}' , [CategoryController::class , 'destroy'])->name('admin-category-delete');
   
    Route::get('/admin/subcategory' , [SubCategoryController::class , 'index'])->name('admin-subcategory');
    Route::get('/admin/subcategory/create' , [SubCategoryController::class , 'create'])->name('admin-subcategory-create');
    Route::post('/admin/subcategory/store' , [SubCategoryController::class , 'store'])->name('admin-subcategory-store');
    Route::get('/admin/subcategory/edit/{id}' , [SubCategoryController::class , 'edit'])->name('admin-subcategory-edit');
    Route::post('/admin/subcategory/update/{id}' , [SubCategoryController::class , 'update'])->name('admin-subcategory-update');
    Route::get('/admin/subcategory/delete/{id}' , [SubCategoryController::class , 'destroy'])->name('admin-subcategory-delete');
    
});
