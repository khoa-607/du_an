<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PlayersController;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CountryController ;
use App\Http\Controllers\Admin\BlogsController ;
use App\Http\Controllers\Admin\BrandController ;
use App\Http\Controllers\Admin\CategoryController ;


use App\Http\Controllers\Frontend\RegisterController;
use App\Http\Controllers\Frontend\LoginController;
use App\Http\Controllers\Frontend\BlogController;
use App\Http\Controllers\Frontend\AccountController;
use App\Http\Controllers\Frontend\IndexController;
use App\Http\Controllers\Frontend\DetailController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\MailController;


use App\Http\Controllers\Frontend\Auth\LogoutController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application.
| These routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
return view('welcome');
});


// Routes cho Register 
Route::get('/member/register', [RegisterController::class, 'registerForm'])->name('register.form');
Route::post('/member/register', [RegisterController::class, 'register'])->name('register.submit');


//Routes cho Login
Route::get('/member/login', [LoginController::class, 'showLoginForm'])->name('login.form');
Route::post('/member/login', [LoginController::class, 'login'])->name('login.submit');


// Routes cho Logout
Route::post('/member/logout', [LogoutController::class, 'logout'])->name('logout');


Route::group([
    // 'prefix' => 'member', // thêm member vào đầu tất cả route nằm trong group
    // 'namespace' => 'Member', //chỉ controller nằm trong folder Member
    'middleware' => ['member'] //chỉ có member mới có thể vào những trang trong group
], function(){
    // Routes cho Blogs

    Route::get('/member/blogs', [BlogController::class, 'list'])->name('blogs.list');
    Route::get('/member/blogs/{id}', [BlogController::class, 'detail'])->name('blogs.detail');
    Route::post('member/blogs/rate', [BlogController::class, 'rate'])->middleware('auth')->name('blogs.rate');
    Route::get('/get-average-ratings', [FrontendController::class, 'getAverageRatings'])->name('get.average.ratings');
    Route::post('/member/blogs/comments', [BlogController::class, 'comment'])->name('blogs.comment');


    // Routes cho Account
    Route::get('/member/account', [AccountController::class, 'account'])->name('account');
    Route::get('member/account/form', [AccountController::class, 'showForm'])->name('account.form');
    Route::post('/member/account/update', [AccountController::class, 'update'])->name('account.update');
    Route::get('/member/account/my-product', [AccountController::class, 'myProduct'])->name('account.my-product');
    Route::get('/member/account/add-product', [AccountController::class, 'showAddProductForm'])->name('account.show-add-product-form');
    Route::post('/member/account/add-product', [AccountController::class, 'addProduct'])->name('account.add-product');
    Route::get('/member/account/edit-product/{id}', [AccountController::class, 'editProduct'])->name('account.edit-product');
    Route::post('/member/account/update-product/{id}', [AccountController::class, 'updateProduct'])->name('account.update-product');
    Route::post('/member/account/delete-product/{id}', [AccountController::class, 'deleteProduct'])->name('account.delete-product');


    // Routes cho Home cua shop
    Route::get('/member/home', [IndexController::class, 'index'])->name('member-home');
    Route::get('/member/home/search', [IndexController::class, 'search'])->name('member-home.search');
    Route::get('/member/home/filter-products', [IndexController::class, 'filterProducts'])->name('member-home.filter-products');
    Route::get('/member/home/detail/{id}', [IndexController::class, 'detail'])->name('member-home.detail');


    // Routes cho Add to cart
    Route::get('/member/cart/show', [CartController::class, 'cart'])->name('cart.show');
    Route::post('/member/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
    Route::get('/member/cart/clear', [CartController::class, 'clearCart'])->name('cart.clear');
    Route::post('/cart/remove', [CartController::class, 'removeFromCart'])->name('cart.remove');
    Route::post('/cart/update', [CartController::class, 'updateCart'])->name('cart.update');


    // Routes cho Mail
    Route::get('/member/checkout', [MailController::class, 'index'])->name('mail.checkout');
    Route::get('/member/send-mail', [MailController::class, 'send'])->name('mail.send');

});



// Routes cho Players (bài tập ngoài)
Route::get('/players/create', [PlayersController::class, 'create'])->name('players.create');
Route::post('/players/store', [PlayersController::class, 'store'])->name('players.store');
Route::get('/players/list', [PlayersController::class, 'list'])->name('players.list');
Route::get('/players/edit/{id}', [PlayersController::class, 'edit'])->name('players.edit');
Route::post('/players/update/{id}', [PlayersController::class, 'update'])->name('players.update');
Route::get('/players/delete/{id}', [PlayersController::class, 'delete'])->name('players.delete');



// Tạo hệ thống login và register
Auth::routes();

Route::group([
    // 'prefix' => 'admin', // thêm admin vào đầu tất cả route nằm trong group
    // 'namespace' => 'Admin', //chỉ controller nằm trong folder Admin
    'middleware' => ['admin'] //chỉ có admin mới có thể vào những trang trong group
], function(){
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    // Routes cho Dashboard cua admin
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    // Routes cho User cua admin
    Route::get('/user', [UserController::class, 'user'])->name('user');
    Route::post('/user/update', [UserController::class, 'update'])->name('user.update');


    // Routes cho Countries cua admin
    Route::get('/countries', [CountryController ::class, 'index'])->name('countries.index');
    Route::get('/countries/create', [CountryController ::class, 'create'])->name('countries.create');
    Route::post('/countries', [CountryController ::class, 'store'])->name('countries.store');
    Route::get('/countries/{id}/edit', [CountryController ::class, 'edit'])->name('countries.edit');
    Route::put('/countries/{id}', [CountryController ::class, 'update'])->name('countries.update');
    Route::get('/countries/{id}', [CountryController ::class, 'show'])->name('countries.show'); 
    Route::delete('/countries/{id}', [CountryController ::class, 'destroy'])->name('countries.destroy');


    // Routes cho Brand cua admin
    Route::get('/brands', [BrandController ::class, 'index'])->name('brands.index');
    Route::get('/brands/create', [BrandController ::class, 'create'])->name('brands.create');
    Route::post('/brands', [BrandController ::class, 'store'])->name('brands.store');
    Route::get('/brands/{id}/edit', [BrandController ::class, 'edit'])->name('brands.edit');
    Route::put('/brands/{id}', [BrandController ::class, 'update'])->name('brands.update');
    Route::get('/brands/{id}', [BrandController ::class, 'show'])->name('brands.show'); 
    Route::delete('/brands/{id}', [BrandController ::class, 'destroy'])->name('brands.destroy');


    // Routes cho Category cua admin
    Route::get('/categories', [CategoryController ::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [CategoryController ::class, 'create'])->name('categories.create');
    Route::post('/categories', [CategoryController ::class, 'store'])->name('categories.store');
    Route::get('/categories/{id}/edit', [CategoryController ::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{id}', [CategoryController ::class, 'update'])->name('categories.update');
    Route::get('/categories/{id}', [CategoryController ::class, 'show'])->name('categories.show'); 
    Route::delete('/categories/{id}', [CategoryController ::class, 'destroy'])->name('categories.destroy');

    // Routes cho Blogs cua admin
    Route::get('/blogs', [BlogsController ::class, 'index'])->name('blogs.index');
    Route::get('/blogs/create', [BlogsController ::class, 'create'])->name('blogs.create');
    Route::post('/blogs', [BlogsController ::class, 'store'])->name('blogs.store');
    Route::get('/blogs/{id}/edit', [BlogsController ::class, 'edit'])->name('blogs.edit');
    Route::put('/blogs/{id}', [BlogsController ::class, 'update'])->name('blogs.update');
    Route::get('/blogs/{id}', [BlogsController ::class, 'show'])->name('blogs.show'); 
    Route::delete('/blogs/{id}', [BlogsController ::class, 'destroy'])->name('blogs.destroy');


});

Route::get('/demo', [DemoController::class], 'demo');








