<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\Dashboard\AdminDashboardController;
use App\Http\Controllers\Dashboard\UserDashboardController;
use App\Http\Controllers\Dashboard\VendorDashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\MarketplaceController;
use App\Http\Controllers\WorkshopController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/lang/{locale}', [LocaleController::class, 'update'])->name('locale.switch');

Route::get('/contents', [ContentController::class, 'index'])->name('contents.index');
Route::get('/contents/{slug}', [ContentController::class, 'show'])->name('contents.show');

Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
Route::get('/courses/{slug}', [CourseController::class, 'show'])->name('courses.show');

Route::get('/workshops', [WorkshopController::class, 'index'])->name('workshops.index');
Route::get('/workshops/{slug}', [WorkshopController::class, 'show'])->name('workshops.show');

Route::get('/marketplace', [MarketplaceController::class, 'index'])->name('marketplace.index');
Route::get('/marketplace/{slug}', [MarketplaceController::class, 'show'])->name('marketplace.show');

Route::get('/contact', [ContactController::class, 'create'])->name('contact.create');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::middleware('auth')->group(function () {
    Route::post('/courses/enroll', [CourseController::class, 'enroll'])->name('courses.enroll');
    Route::post('/workshops/book', [WorkshopController::class, 'book'])->name('workshops.book');

    Route::prefix('dashboard')->name('dashboard.')->group(function () {
        Route::get('/', [UserDashboardController::class, 'index'])->name('index');
        Route::get('/courses', [CourseController::class, 'myCourses'])->name('courses');
        Route::get('/bookings', [WorkshopController::class, 'history'])->name('bookings');
    });
});

Route::middleware(['auth', 'can:vendor-area'])->prefix('vendor')->name('vendor.')->group(function () {
    Route::get('/dashboard', [VendorDashboardController::class, 'index'])->name('dashboard');
    Route::resource('products', App\Http\Controllers\Vendor\ProductController::class)->except(['show']);
});

Route::middleware(['auth', 'can:admin-area'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('contents', App\Http\Controllers\Admin\ContentController::class);
    Route::resource('courses', App\Http\Controllers\Admin\CourseController::class);
    Route::resource('workshops', App\Http\Controllers\Admin\WorkshopController::class);
    Route::resource('products', App\Http\Controllers\Admin\ProductController::class);
    Route::resource('users', App\Http\Controllers\Admin\UserController::class);
    Route::resource('contact-inquiries', App\Http\Controllers\Admin\ContactInquiryController::class);
});
