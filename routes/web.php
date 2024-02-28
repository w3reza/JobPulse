<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\packageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Backend\jobController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\SkillController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\JobsController;
use App\Http\Controllers\backend\VendorController;
use App\Http\Controllers\Backend\backendController;
use App\Http\Controllers\Backend\JobTypeController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\StockHistoryController;

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

// Route::get('/', function () {
//     return view('welcome');
// });


//Routing Group without Middleware

/*
|--------------------------------------------------------------------------
| Admin Web Routes with admin prefix
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

Route::prefix('admin')->group(function () {
    Route::get('/', [backendController::class, 'index'])->name('admin.dashboard');

/*
|--------------------------------------------------------------------------
| Packages Routes
|--------------------------------------------------------------------------
*/

Route::get('/packages', [packageController::class, 'show'])->name('packages.show');
Route::get('package/create', [packageController::class, 'create'])->name('package.create');
Route::post('package/store', [packageController::class, 'store'])->name('package.store');



/*
|--------------------------------------------------------------------------
| Admin Job Section Job Routes
|--------------------------------------------------------------------------
*/

Route::get('/jobs', [jobController::class, 'show'])->name('jobs.show');
Route::get('job/create', [jobController::class, 'create'])->name('job.create');
Route::post('job/store', [jobController::class, 'store'])->name('job.store');


/*
|--------------------------------------------------------------------------
| Category Routes
|--------------------------------------------------------------------------
*/

Route::get('/category', [CategoryController::class, 'index'])->name('category.index');
Route::get('/category/create', [CategoryController::class, 'create'])->name('category.create');
Route::post('/category/store', [CategoryController::class, 'store'])->name('category.store');
Route::get('/category/edit/{id}', [CategoryController::class, 'edit'])->name('category.edit');
Route::post('/category/{id}', [CategoryController::class, 'update'])->name('category.update');
Route::delete('/category/{id}', [CategoryController::class, 'destroy'])->name('category.destroy');




/*
|--------------------------------------------------------------------------
| TobType Routes
|--------------------------------------------------------------------------
*/

Route::get('/job_type_list', [JobTypeController::class, 'index'])->name('JobType.index');
Route::get('/job_type/create', [JobTypeController::class, 'create'])->name('JobType.create');
Route::post('/job_type/store', [JobTypeController::class, 'store'])->name('JobType.store');
Route::get('/job_type/edit/{id}', [JobTypeController::class, 'edit'])->name('JobType.edit');
Route::post('/job_type/{id}', [JobTypeController::class, 'update'])->name('JobType.update');
Route::delete('/job_type/{id}', [JobTypeController::class, 'destroy'])->name('JobType.destroy');


/*
|--------------------------------------------------------------------------
| skill Routes
|--------------------------------------------------------------------------
*/

Route::get('/skills', [SkillController::class, 'index'])->name('skill.index');
Route::get('/skill/create', [SkillController::class, 'create'])->name('skill.create');
Route::post('/skill/store', [SkillController::class, 'store'])->name('skill.store');
Route::get('/skill/edit/{id}', [SkillController::class, 'edit'])->name('skill.edit');
Route::post('/skill/{id}', [SkillController::class, 'update'])->name('skill.update');
Route::delete('/skill/{id}', [SkillController::class, 'destroy'])->name('skill.destroy');

/*
|--------------------------------------------------------------------------
| Job Routes
|--------------------------------------------------------------------------
*/

Route::get('/jobs', [JobController::class, 'index'])->name('job.index');
Route::get('/job/create', [JobController::class, 'create'])->name('job.create');
Route::post('/job/store', [JobController::class, 'store'])->name('job.store');
Route::get('/job/edit/{id}', [JobController::class, 'edit'])->name('job.edit');
Route::post('/job/{id}', [JobController::class, 'update'])->name('job.update');
Route::delete('/job/{id}', [JobController::class, 'destroy'])->name('job.destroy');



/*
|--------------------------------------------------------------------------
| Users Routes
|--------------------------------------------------------------------------
*/

Route::group(['middleware' => ['role:superadmin']], function () {
    Route::get('/users', [UserController::class, 'UserList'])->name('users.list');
});



Route::get('/company_list', [UserController::class, 'CompanyList'])->name('company.list');
// Route::get('/job/create', [JobController::class, 'create'])->name('job.create');
// Route::post('/job/store', [JobController::class, 'store'])->name('job.store');
Route::get('/user/edit/{id}', [JobController::class, 'edit'])->name('user.edit');
Route::post('/user/{id}', [JobController::class, 'update'])->name('user.update');
Route::delete('/user/{id}', [JobController::class, 'destroy'])->name('user.destroy');


/*
|--------------------------------------------------------------------------
| Vendor Routes
|--------------------------------------------------------------------------
*/

Route::get('/vendor', [VendorController::class, 'index'])->name('vendor.index');
Route::get('/vendor/create', [VendorController::class, 'create'])->name('vendor.create');
Route::post('/vendor/store', [VendorController::class, 'store'])->name('vendor.store');
Route::get('/vendor/edit/{id}', [VendorController::class, 'edit'])->name('vendor.edit');
Route::post('/vendor/{id}', [VendorController::class, 'update'])->name('vendor.update');
Route::delete('/vendor/{id}', [VendorController::class, 'destroy'])->name('vendor.destroy');


/*
|--------------------------------------------------------------------------
| Product Routes
|--------------------------------------------------------------------------
*/

Route::get('/product', [ProductController::class, 'index'])->name('product.index');
Route::get('/product/create', [ProductController::class, 'create'])->name('product.create');
Route::post('/product/store', [ProductController::class, 'store'])->name('product.store');
Route::get('/product/edit/{id}', [ProductController::class, 'edit'])->name('product.edit');
Route::post('/product/{id}', [ProductController::class, 'update'])->name('product.update');
Route::delete('/product/{id}', [ProductController::class, 'destroy'])->name('product.destroy');

/*
|--------------------------------------------------------------------------
| Product Routes
|--------------------------------------------------------------------------
*/

Route::get('/stock', [StockHistoryController::class, 'index'])->name('stock.index');
Route::get('/stock/create', [StockHistoryController::class, 'create'])->name('stock.create');
Route::post('/stock/store', [StockHistoryController::class, 'store'])->name('stock.store');
Route::get('/stock/edit/{id}', [StockHistoryController::class, 'edit'])->name('stock.edit');
Route::post('/stock/{id}', [StockHistoryController::class, 'update'])->name('stock.update');
Route::delete('/stock/{id}', [StockHistoryController::class, 'destroy'])->name('stock.destroy');



});


});


/*
|--------------------------------------------------------------------------
| End of Admin Web Routes with admin prefix
|--------------------------------------------------------------------------
*/

Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/AssignRole', [UserController::class, 'AssignRole']);

/*
|--------------------------------------------------------------------------
| Frontend Web Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/home_page', [HomeController::class, 'home_page'])->name('home_page');
Route::get('/jobs',[JobsController::class,'index'])->name('jobs');
Route::get('/jobs/detail/{id}',[JobsController::class,'detail'])->name('jobDetail');
Route::post('/apply-job',[JobsController::class,'applyJob'])->name('applyJob');
Route::post('/save-job',[JobsController::class,'saveJob'])->name('saveJob');

Route::post('/user/create', [UserController::class, 'Store'])->name('user.store');






