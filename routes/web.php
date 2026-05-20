<?php

use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminReportController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FoundItemController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LostItemController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\MyReportController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact', [PageController::class, 'contactSubmit'])->middleware('throttle:5,1')->name('contact.submit');

Route::get('/lost-items', [LostItemController::class, 'index'])->name('lost-items.index');
Route::get('/lost-items/search', [LostItemController::class, 'search'])->name('lost-items.search');

Route::get('/found-items', [FoundItemController::class, 'index'])->name('found-items.index');
Route::get('/found-items/search', [FoundItemController::class, 'search'])->name('found-items.search');

Route::middleware(['auth', 'verified', 'not.blocked'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/my-reports', [MyReportController::class, 'index'])->name('my-reports.index');

    Route::resource('lost-items', LostItemController::class)->except(['index', 'show']);
    Route::post('/lost-items/{lost_item:slug}/recovered', [LostItemController::class, 'markRecovered'])->name('lost-items.recovered');
    Route::get('/lost-items/{lost_item:slug}/pdf', [LostItemController::class, 'exportPdf'])->name('lost-items.pdf');
    Route::post('/lost-items/{lost_item:slug}/comments', [CommentController::class, 'storeLost'])->middleware('throttle:10,1')->name('lost-items.comments.store');
    Route::post('/lost-items/{lost_item:slug}/bookmark', [BookmarkController::class, 'toggleLost'])->name('lost-items.bookmark');

    Route::resource('found-items', FoundItemController::class)->except(['index', 'show']);
    Route::post('/found-items/{found_item:slug}/returned', [FoundItemController::class, 'markReturned'])->name('found-items.returned');
    Route::get('/found-items/{found_item:slug}/pdf', [FoundItemController::class, 'exportPdf'])->name('found-items.pdf');
    Route::post('/found-items/{found_item:slug}/comments', [CommentController::class, 'storeFound'])->middleware('throttle:10,1')->name('found-items.comments.store');
    Route::post('/found-items/{found_item:slug}/bookmark', [BookmarkController::class, 'toggleFound'])->name('found-items.bookmark');

    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllRead'])->name('notifications.read-all');
    Route::get('/notifications/poll', [NotificationController::class, 'poll'])->name('notifications.poll');

    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/create', [MessageController::class, 'create'])->name('messages.create');
    Route::post('/messages', [MessageController::class, 'store'])->middleware('throttle:10,1')->name('messages.store');
    Route::get('/messages/{message}', [MessageController::class, 'show'])->name('messages.show');
    Route::patch('/messages/{message}/status', [MessageController::class, 'updateStatus'])->name('messages.status');

    Route::get('/bookmarks', [BookmarkController::class, 'index'])->name('bookmarks.index');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/lost-items/{lost_item:slug}', [LostItemController::class, 'show'])->name('lost-items.show');
Route::get('/found-items/{found_item:slug}', [FoundItemController::class, 'show'])->name('found-items.show');

Route::prefix('admin')->middleware(['auth', 'verified', 'not.blocked', 'admin'])->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::patch('/users/{user}/block', [AdminUserController::class, 'toggleBlock'])->name('users.block');
    Route::patch('/users/{user}/admin', [AdminUserController::class, 'toggleAdmin'])->name('users.admin');
    Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');

    Route::get('/reports', [AdminReportController::class, 'index'])->name('reports.index');
    Route::delete('/reports/lost/{lost_item}', [AdminReportController::class, 'destroyLost'])->name('reports.lost.destroy');
    Route::delete('/reports/found/{found_item}', [AdminReportController::class, 'destroyFound'])->name('reports.found.destroy');

    Route::get('/categories', [AdminCategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [AdminCategoryController::class, 'store'])->name('categories.store');
    Route::patch('/categories/{category}', [AdminCategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [AdminCategoryController::class, 'destroy'])->name('categories.destroy');
});

require __DIR__.'/auth.php';
