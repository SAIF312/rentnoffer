<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SettingController;
// use App\Http\Controllers\ChatsController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});



Route::middleware('auth','role:admin')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


    // ChatsController
    // Route::get('/', [ChatsController::class, 'index']);
    // Route::get('messages', [ChatsController::class, 'fetchMessages']);
    // Route::post('messages', [ChatsController::class, 'sendMessage']);

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //User
    Route::get('/users', [UserController::class, 'index'])->name('users');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users/store', [UserController::class, 'store'])->name('users.store');
    Route::get('/users_data', [UserController::class, 'user_data'])->name('users.datatable');
    Route::get('user_disable/{id}', [UserController::class, 'disable']);
    Route::get('user_block/{id}', [UserController::class, 'block']);
    Route::get('user_active/{id}', [UserController::class, 'active']);
    // Category
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories');
    Route::get('/category_data', [CategoryController::class, 'category_data'])->name('categories.datatable');
    Route::get('/categories/add', [CategoryController::class, 'add_category_index'])->name('add_category');
    Route::post('/add_categories', [CategoryController::class, 'add_category'])->name('add_categories');
    Route::get('/categories/{id}/edit', [CategoryController::class, 'edit_category'])->name('categories.edit');

    Route::get('category_disable/{id}', [CategoryController::class, 'disable']);
    Route::get('category_active/{id}', [CategoryController::class, 'active']);
    Route::get('category_delete/{id}', [CategoryController::class, 'delete']);

    // Attribute
    Route::get('attributes', [AttributeController::class, 'index'])->name('attribute_group');
    Route::get('attributes/data', [AttributeController::class, 'attribute_data'])->name('attributes.datatable');
    Route::get('attributes/create', [AttributeController::class, 'add_attribute_index'])->name('add_attribute');
    Route::post('attributes/store', [AttributeController::class, 'add_attributes'])->name('add_attributess');
    Route::get('attributes/{id}/edit', [AttributeController::class, 'edit_attribute'])->name('attributes.edit');
    Route::post('attributes/{id}/update', [AttributeController::class, 'update_attribute'])->name('attributes.update');
    Route::Post('attributes/status', [AttributeController::class, 'change_status'])->name('attributes.status');
    Route::get('attribute_delete/{id}', [AttributeController::class, 'delete']);

    //Products
    Route::get('approved/products', [ProductController::class, 'active_index'])->name('approved_index');
    Route::get('disabled/products', [ProductController::class, 'disabled_index'])->name('disabled_index');
    Route::get('rejected/products', [ProductController::class, 'rejected_index'])->name('rejected_index');
    Route::get('pending/products', [ProductController::class, 'pending_index'])->name('pending_index');
    Route::get('product/approved', [ProductController::class, 'approved'])->name('products.approved');
    Route::get('product/deactivate', [ProductController::class, 'deactivate'])->name('products.deactivated');
    Route::get('product/rejected', [ProductController::class, 'rejected'])->name('products.rejected');
    Route::get('product/pending', [ProductController::class, 'pending'])->name('products.pending');
    Route::get('add_product', [ProductController::class, 'add_product_index'])->name('add_product');
    Route::post('add_productss', [ProductController::class, 'add_products'])->name('add_productss');
    Route::get('accept_product/{id}', [ProductController::class, 'accept_product']);
    Route::get('reject_product/{id}', [ProductController::class, 'reject_product']);
    Route::get('product_disable/{id}', [ProductController::class, 'disable']);
    Route::get('product_active/{id}', [ProductController::class, 'active']);
    Route::get('product_delete/{id}', [ProductController::class, 'delete']);
    Route::get('product_group', [ProductController::class, 'index'])->name('product_group');

    // invoices
    Route::get('invoices/index', [PaymentController::class, 'index'])->name('invoices_index');
    Route::post('invoices/detail', [PaymentController::class, 'detail'])->name('invoices.detail');

    Route::get('invoices', [PaymentController::class, 'invoices'])->name('invoices');

    // pages
    Route::get('pages/show_all', [PageController::class, 'show_all'])->name('pages.show_all');
    Route::Post('pages/status', [PageController::class, 'change_status'])->name('pages.status');
    Route::resource('pages', PageController::class);

    //orders
    Route::get('orders/show_all', [OrderController::class, 'show_all'])->name('orders.show_all');
    Route::Post('orders/status', [OrderController::class, 'change_status'])->name('orders.status');
    Route::get('orders/{id}/pdf', [OrderController::class, 'create_pdf'])->name('orders.pdf');
    Route::resource('orders', OrderController::class);

    //reports
    Route::get('reports/top_sales_product', [ReportController::class, 'top_sales_product'])->name('reports.top_sales_product');
    Route::get('reports/top_viewed_product', [ReportController::class, 'top_viewed_product'])->name('reports.top_viewed_product');
    Route::get('reports/top_orders', [ReportController::class, 'top_orders'])->name('reports.top_orders');
    Route::get('reports/top_borrowers', [ReportController::class, 'top_borrowers'])->name('reports.top_borrowers');
    Route::get('reports/top_lenders', [ReportController::class, 'top_lenders'])->name('reports.top_lenders');
    Route::resource('reports', ReportController::class);


    Route::get('roles/show_all', [RoleController::class, 'show_all'])->name('roles.show_all');
    Route::resource('roles', RoleController::class);

    Route::resource('settings', SettingController::class);
});

require __DIR__ . '/auth.php';
