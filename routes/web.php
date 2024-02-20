<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController ;
use App\Http\Controllers\admin\DashboardController ;
use App\Http\Controllers\admin\PostController ;
use App\Http\Controllers\admin\ViralPostController ;
use App\Http\Controllers\admin\CategoryController ;
use App\Http\Controllers\admin\SubCategoryController ;
use App\Http\Controllers\admin\TopicController ;
use App\Http\Controllers\admin\WriterController ;
use App\Http\Controllers\admin\Gallery ;
use App\Http\Controllers\admin\SocialController ;
use App\Http\Controllers\FrontSocialController ;

use App\Http\Controllers\PasswordResetController;

use Illuminate\Support\Facades\Auth ;











Auth::routes();
Route::get('logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

Route::get('/', [HomeController::class, 'index'])->name('home');
//Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/topics/index',[FrontSocialController::class , 'index'])->name('topic-page');
Route::get('/topic/{topic}',[FrontSocialController::class , 'getTopic'])->name('s-topic-seo');
Route::get('/topic/{topic}/{social}',[FrontSocialController::class , 'getSocial'])->name('s-social-seo');
Route::post('/get/blog/page/topic',[FrontSocialController::class , 'getBlogByPage']);
Route::get('/get/blog/page/alltopic',[FrontSocialController::class , 'getAllTopic']);
Route::post('/get/topic/page/alltopic/search',[FrontSocialController::class , 'searchInTopic'])->name('search-in-topics');
Route::post('/get/topic/page/search',[FrontSocialController::class , 'searchpage'])->name('search-in-social');





//blog routes start
Route::get('/{name}',[HomeController::class , 'getblog'])->name('get-blogs');
Route::post('/get/blog/page',[HomeController::class , 'getBlogByPage'])->name('get-blog-page'); // for page in index // for blog
//Route::post('/get/viralblog/page',[HomeController::class , 'getViralBlogByPage'])->name('get-viralblog-page'); // for page in index // for blog

Route::get('/category/index',[HomeController::class , 'getCategory'])->name('category-index-byseo');
Route::get('/category/{name}',[HomeController::class , 'getCategoryBySeo'])->name('category-byseo');
Route::post('/get/blog/category/page',[HomeController::class , 'getBlogByPageCategory'])->name('get-blog-category-page'); // for page in index // for blog
//Route::post('/get/viralblog/category/page',[HomeController::class , 'getViralBlogByPageCategory'])->name('get-viralblog-category-page'); // for page in index // for blog

Route::get('/tags/index',[HomeController::class , 'getSubCategory'])->name('subcategory-index-byseo');
Route::get('/tags/{name}',[HomeController::class , 'getSubCategoryBySeo'])->name('subcategory-byseo');
Route::post('/get/blog/tag/page',[HomeController::class , 'getBlogByPageTag'])->name('get-blog-tag-page'); 
//Route::post('/get/viralblog/tag/page',[HomeController::class , 'getViralBlogByPageTag'])->name('get-viralblog-tag-page');

Route::post('/get/blog/comment/add', [HomeController::class , 'addComment'])->name('get-blog-comment-add'); 
Route::post('/get/blog/comment/social/add', [HomeController::class , 'addCommentSocial'])->name('get-blog-comment-social-add'); 




Route::post('/search',[HomeController::class , 'searchpage'])->name('search-page');



Route::group(['middleware'  => ['role:admin|writer|user']] , function(){

    Route::get('/admin/resetPassword' ,   [PasswordResetController::class , 'getPage' ])->name('admin-reset-password');
    Route::post('/admin/updatePassword' , [PasswordResetController::class , 'reset' ])->name('admin-update-password');
    Route::get('/admin/dashboard' ,       [DashboardController::class , 'dashboard' ])->name('admin-dashboard');
    Route::get('/admin/premium' ,         [DashboardController::class , 'premium' ])->name('admin-premium');
    Route::get('/admin/tutorial' ,        [DashboardController::class , 'tutorial' ])->name('admin-tutorial');

  
    
    Route::get('/admin/topic' ,              [TopicController::class , 'index'])->name('admin-topic');
    Route::get('/admin/topic/create' ,       [TopicController::class , 'create'])->name('admin-topic-create');
    Route::post('/admin/topic/store' ,       [TopicController::class , 'store'])->name('admin-topic-store');
    Route::get('/admin/topic/edit/{id}' ,    [TopicController::class , 'edit'])->name('admin-topic-edit');
    Route::post('/admin/topic/update/{id}' , [TopicController::class , 'update'])->name('admin-topic-update');
    Route::get('/admin/topic/delete/{id}' ,  [TopicController::class , 'destroy'])->name('admin-topic-delete');

       
  

    Route::get('/admin/social' , [SocialController::class , 'index'])->name('admin-social');
    Route::get('/admin/social/create' , [SocialController::class , 'create'])->name('admin-social-create');
    Route::post('/admin/social/store' , [SocialController::class , 'store'])->name('admin-social-store');
    Route::get('/admin/social/edit/{id}' , [SocialController::class , 'edit'])->name('admin-social-edit');
    Route::post('/admin/social/update/{id}' , [SocialController::class , 'update'])->name('admin-social-update');
    Route::get('/admin/social/delete/{id}' , [SocialController::class , 'destroy'])->name('admin-social-delete');
    

    //jquery routes
    Route::post('/admin/get/subcategory' , [DashboardController::class , 'getsubcategory'])->name('admin-get-subcategory');
    Route::post('/admin/get/topic' , [DashboardController::class , 'gettopic'])->name('admin-get-topic');
   
    

});

Route::group(['middleware'  => ['role:admin|writer']] , function(){

    Route::get('/admin/blog' , [PostController::class , 'index'])->name('admin-blog');
    Route::get('/admin/blog/create' , [PostController::class , 'create'])->name('admin-blog-create');
    Route::post('/admin/blog/store' , [PostController::class , 'store'])->name('admin-blog-store');
    Route::get('/admin/blog/edit/{id}' , [PostController::class , 'edit'])->name('admin-blog-edit');
    Route::post('/admin/blog/update/{id}' , [PostController::class , 'update'])->name('admin-blog-update');
    Route::get('/admin/blog/delete/{id}' , [PostController::class , 'destroy'])->name('admin-blog-delete');

});

Route::group(['middleware'  => ['role:admin']] , function(){

    Route::get('/admin/blog/pending' , [PostController::class , 'getPending'])->name('admin-blog-pending');
    Route::get('/admin/blog/deleted' , [PostController::class , 'getDeleted'])->name('admin-blog-deleted');

    Route::get('/admin/topic/pending' , [TopicController::class , 'getPending'])->name('admin-topic-pending');
    Route::get('/admin/topic/deleted' , [TopicController::class , 'getDeleted'])->name('admin-topic-deleted');

    Route::get('/admin/social/pending' , [PostController::class , 'getPending'])->name('admin-social-pending');
    Route::get('/admin/social/deleted' , [PostController::class , 'getDeleted'])->name('admin-social-deleted');


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

    Route::get('/admin/writer',[WriterController::class, 'index'])->name('admin-writer');
	Route::get('/admin/writer/create',[WriterController::class, 'create'])->name('admin-writer-create');
	Route::post('/admin/writer/store',[WriterController::class, 'store'])->name('admin-writer-store');
	Route::get('/admin/writer/edit/{id}',[WriterController::class, 'edit'])->name('admin-writer-edit');
    Route::post('/admin/writer/edit/update/{id}',[WriterController::class, 'update'])->name('admin-writer-update');
    Route::get('/admin/writer/delete/{id}',[WriterController::class, 'destroy'])->name('admin-writer-delete');


    Route::get('/admin/find/danger/article',[Gallery::class, 'find'])->name('admin-find-danger-article');
    Route::get('/admin/find/danger/article2',[Gallery::class, 'find2'])->name('admin-find-danger-article2');
 
});
