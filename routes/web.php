<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Promoter\DashboardController;
use App\Http\Controllers\Promoter\EventController;
use App\Http\Controllers\Promoter\TicketController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/tickets', function () {
    return view('tickets');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/logout', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'destroy']);
});

Route::prefix('promoter/dashboard')->middleware(['auth', 'admin', 'promoter'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('promoter.dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // ========== Ticket routes goes here ======== \\
    Route::get('/tickets', [TicketController::class, 'index'])->name('promoter.ticket.index');
    Route::get('/tickets/create', [TicketController::class, 'create'])->name('promoter.ticket.create');
    Route::post('/tickets/create', [TicketController::class, 'store'])->name('promoter.ticket.store');
    Route::post('/ticket/delete', [TicketController::class, 'delete']);
    // ========== Ticket routes ends here ======== \\
    
    // ========== Event routes goes here ======== \\
    Route::get('/events', [EventController::class, 'index'])->name('promoter.event.index');
    Route::post('/events/paginate', [EventController::class, 'paginateEvents']);
    Route::post('/events/create', [EventController::class, 'store']);
    Route::get('/events/create', [EventController::class, 'create'])->name('promoter.event.create');
    // ========== Event routes goes here ======== \\
    // ========== Attendancec route goes here ======= \\
    Route::post('/ticket/attendance/search', [\App\Http\Controllers\Promoter\AttendanceController::class, 'search']);
    Route::post('/ticket/attendance/mark', [\App\Http\Controllers\Promoter\AttendanceController::class, 'markUserAsPresent']);
    // ========== Ends here ============\\
});

Route::prefix('admin/dashboard')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [\App\Http\Controllers\Admin\DashboardController::class, 'index']);
    // ========== User routes goes here ======== \\
    Route::get('/users', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('admin.user.index');
    Route::post('/users/paginate', [\App\Http\Controllers\Admin\UserController::class, 'paginateUsers']);
    Route::post('/users/search', [\App\Http\Controllers\Admin\UserController::class, 'search']);
    // ========== User routes ends here ======== \\
    
    // ========== Event routes goes here ======== \\
    Route::get('/events', [\App\Http\Controllers\Admin\EventController::class, 'index'])->name('admin.event.index');
    Route::post('/events/paginate', [\App\Http\Controllers\Admin\EventController::class, 'paginateEvents']);
    Route::post('/events/search', [\App\Http\Controllers\Admin\EventController::class, 'search']);
    Route::post('/event/delete', [\App\Http\Controllers\Admin\EventController::class, 'delete']);
    Route::post('/event/premium/toggle', [\App\Http\Controllers\Admin\EventController::class, 'togglePremium']);
    // ========== Event routes goes here ======== \\
});

require __DIR__.'/auth.php';
