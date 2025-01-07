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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [\App\Http\Controllers\User\EventController::class, 'homepage']);
Route::post('/events/filterByState', [\App\Http\Controllers\User\EventController::class, 'searchByState']);
// ========== Game routes goes here ======== \\
Route::get('/games', [\App\Http\Controllers\GameController::class, 'index'])->name('admin.games.index');
Route::post('/games/paginate', [\App\Http\Controllers\GameController::class, 'paginateGames']);
Route::post('/games/search', [\App\Http\Controllers\GameController::class, 'search']);
Route::post('/games/search/tag', [\App\Http\Controllers\GameController::class, 'searchByTags']);
    // ========== Plugs routes goes here ======== \\
Route::get('/plugs', [\App\Http\Controllers\Plug\PlugController::class, 'index'])->name('plug.list');
Route::post('/plugs/search', [\App\Http\Controllers\Plug\PlugController::class, 'search']);
Route::post('/plugs/search/tags', [\App\Http\Controllers\Plug\PlugController::class, 'searchByTags']);
Route::get('/plugs/search/paginate', [\App\Http\Controllers\Plug\PlugController::class, 'paginateUsers']);
// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/facecard', [ProfileController::class, 'facecard'])->name('profile.update.facecard');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/logout', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'destroy']);
    Route::post('/plug/dashboard/create', [\App\Http\Controllers\Plug\PlugController::class, 'store']);
    Route::post('/plugs', [\App\Http\Controllers\Plug\PlugController::class, 'store']);
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
    Route::post('/event/status', [EventController::class, 'updateStatus']);
    Route::post('/events/promotional_video', [EventController::class, 'add_promotional_media']);
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
    Route::post('/users/roles/unassign', [\App\Http\Controllers\Admin\RoleController::class, 'RemoveRoleFromUser']);
    Route::post('/users/roles/assign', [\App\Http\Controllers\Admin\RoleController::class, 'AddRoleToUser']);
    // ========== User routes ends here ======== \\
    
    // ========== Event routes goes here ======== \\
    Route::get('/events', [\App\Http\Controllers\Admin\EventController::class, 'index'])->name('admin.event.index');
    Route::post('/events/paginate', [\App\Http\Controllers\Admin\EventController::class, 'paginateEvents']);
    Route::post('/events/search', [\App\Http\Controllers\Admin\EventController::class, 'search']);
    Route::post('/event/delete', [\App\Http\Controllers\Admin\EventController::class, 'delete']);
    Route::post('/event/premium/toggle', [\App\Http\Controllers\Admin\EventController::class, 'togglePremium']);
    // ========== Event routes goes here ======== \\
    // 
    
    // ========== Game routes goes here ======== \\
    Route::get('/games', [\App\Http\Controllers\Admin\GameController::class, 'index'])->name('admin.games.index');
    Route::post('/games/paginate', [\App\Http\Controllers\Admin\GameController::class, 'paginateGames']);
    Route::post('/games/search', [\App\Http\Controllers\Admin\GameController::class, 'search']);
    Route::get('/games/create', [\App\Http\Controllers\Admin\GameController::class, 'create']);
    Route::post('/games/create', [\App\Http\Controllers\Admin\GameController::class, 'store']);
    // ========== Event routes goes here ======== \\
});

Route::prefix('user/dashboard')->middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('user.profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/facecard', [ProfileController::class, 'facecard'])->name('profile.update.facecard');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/', [\App\Http\Controllers\User\UserController::class, 'index'])->name('user.dashboard.home');    
    // ========== Event routes goes here ======== \\
    Route::get('/events', [\App\Http\Controllers\User\EventController::class, 'index']);
    Route::post('/events/search', [\App\Http\Controllers\User\UserController::class, 'search']);
    // ========== Event routes goes here ======== \\

    
     // ========== Ticket routes goes here ======== \\
    Route::get('/tickets', [\App\Http\Controllers\User\TicketController::class, 'index'])->name('user.dashboard.tickets');
    Route::get('/tickets/upcoming', [\App\Http\Controllers\User\TicketController::class, 'upcomingEvents']);
    Route::post('/tickets/checkout', [\App\Http\Controllers\User\TicketController::class, 'toCheckout']);
    Route::get('/ticket/checkout', [\App\Http\Controllers\User\TicketController::class, 'Checkout'])->name('user.dashboard.ticket.checkout');
    // ========== Ticket routes goes here ======== \\
    
    // ========== Game routes goes here ======== \\
    Route::get('/games', [\App\Http\Controllers\User\GameController::class, 'index'])->name('admin.games.index');
    Route::post('/games/paginate', [\App\Http\Controllers\User\GameController::class, 'paginateGames']);
    Route::post('/games/search', [\App\Http\Controllers\User\GameController::class, 'search']);
    // ========== Event routes goes here ======== \\
});
require __DIR__.'/auth.php';
