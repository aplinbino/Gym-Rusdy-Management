<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminPtController;
use App\Http\Controllers\AdminTransaksiController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdminScheduleController;
use App\Http\Controllers\DashboardUserController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\PersonalTrainerController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\AdminProfileController;

use App\Models\Pt;


// ==========================================
// HALAMAN UMUM
// ==========================================

Route::get('/', function () {
    return view('welcome');
});

Route::get('/sign_up', function () {
    return view('sign_up');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/login-with-role', function () {
    return view('login_with_role');
});


// ==========================================
// ROUTE MEMBER
// ==========================================

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard_user', [DashboardUserController::class, 'index'])
        ->name('user.dashboard_user');

    Route::put('/member/profile', [DashboardUserController::class, 'updateProfile'])
        ->name('member.profile.update');

    Route::put('/member/password', [DashboardUserController::class, 'updatePassword'])
        ->name('member.password.update');

    Route::post('/member/jadwal', [DashboardUserController::class, 'storeSchedule'])
        ->name('member.schedule.store');

    // Review Personal Trainer oleh member.
    Route::get('/member/review-pt/{pt}', [ReviewController::class, 'create'])
        ->name('member.pt-review.create');

    Route::post('/member/review-pt/{pt}', [ReviewController::class, 'store'])
        ->name('member.pt-review.store');

    // Halaman Membership
    Route::get('/membership', function () {

        $pts = Pt::where('status', 'active')->get();

        $availabilities = DB::table('pt_availabilities as pa')
            ->join('pt_profiles as pp', 'pp.id', '=', 'pa.pt_profile_id')
            ->join('pt as p', 'p.user_id', '=', 'pp.user_id')
            ->where('p.status', 'active')
            ->where('pa.status', 'available')
            ->where('pa.start_at', '>', now())
            ->select(
                'pa.id',
                'p.id as pt_id',
                'pa.start_at',
                'pa.end_at'
            )
            ->orderBy('pa.start_at')
            ->get();

        return view('user.membership', compact(
            'pts',
            'availabilities'
        ));
    });

    // Checkout Membership
    Route::post('/membership', [MembershipController::class, 'store'])
        ->name('membership.store');

    // Booking PT tanpa membeli Membership baru
    Route::get('/member/booking-pt', [MembershipController::class, 'bookingPt'])
        ->name('member.pt-booking');

    Route::post('/member/booking-pt', [MembershipController::class, 'storePtBooking'])
        ->name('member.pt-booking.store');


    // ==========================================
    // ROUTE PERSONAL TRAINER
    // ==========================================

    Route::get('/personal-trainer', [PersonalTrainerController::class, 'index'])
        ->name('pt.dashboard');

    Route::put('/personal-trainer/profil', [PersonalTrainerController::class, 'updateProfile'])
        ->name('pt.profile.update');

    Route::put('/personal-trainer/password', [PersonalTrainerController::class, 'updatePassword'])
        ->name('pt.password.update');

    Route::patch('/personal-trainer/jadwal/{id}', [
        PersonalTrainerController::class,
        'updateSchedule'
    ])->name('pt.schedule.update');

    Route::post('/personal-trainer/ketersediaan', [
        PersonalTrainerController::class,
        'storeAvailability'
    ])->name('pt.availability.store');

    Route::patch('/personal-trainer/ketersediaan/{id}/nonaktifkan', [
        PersonalTrainerController::class,
        'deactivateAvailability'
    ])->name('pt.availability.deactivate');

});


// ==========================================
// REVIEW MEMBER KE PT
// ==========================================

Route::get('/review_to_pt', function () {
    return view('user.review_to_pt');
});


// ==========================================
// ROUTE JADWAL PT
// ==========================================

Route::get('/schedule', function () {
    return view('personal_trainer.schedule');
});


// ==========================================
// ROUTE HALAMAN ADMIN
// ==========================================

Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])
    ->middleware('auth')
    ->name('admin.dashboard');

Route::get('/tabel_user', function () {
    abort_unless(auth()->check() && auth()->user()->role === 'admin', 403);
    return view('admin.tabel_user');
})->middleware('auth');

Route::get('/tabel_pt', function () {
    return view('admin.tabel_pt');
});

Route::get('/tabel_schedule', function () {
    abort_unless(auth()->check() && auth()->user()->role === 'admin', 403);
    return view('admin.tabel_schedule');
})->middleware('auth');

Route::get('/tabel_transaction', function () {
    abort_unless(auth()->check() && auth()->user()->role === 'admin', 403);
    return view('admin.tabel_transaction');
})->middleware('auth');


// ==========================================
// AUTHENTICATION
// ==========================================

Route::post('/sign_up', [AuthController::class, 'signUp'])
    ->name('sign_up.store');

// Login Member
Route::post('/login', [LoginController::class, 'loginMember'])
    ->name('login.member');

// Login Admin dan PT
Route::post('/login-with-role', [LoginController::class, 'loginStaff'])
    ->name('login.staff');

// Logout
Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout');


// ==========================================
// CRUD PERSONAL TRAINER ADMIN
// ==========================================

Route::get('/admin/pt', [AdminPtController::class, 'index'])
    ->name('admin.pt.index');

Route::post('/admin/pt', [AdminPtController::class, 'store'])
    ->name('admin.pt.store');

Route::put('/admin/pt/{pt}', [AdminPtController::class, 'update'])
    ->name('admin.pt.update');

Route::delete('/admin/pt/{pt}', [AdminPtController::class, 'destroy'])
    ->name('admin.pt.destroy');


// ==========================================
// TRANSAKSI ADMIN
// ==========================================

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/transaksi', function (AdminTransaksiController $controller) {
        abort_unless(auth()->user()->role === 'admin', 403);
        return $controller->index();
    })->name('admin.transaksi.index');
});


// ==========================================
// DATA USER ADMIN
// ==========================================

Route::get('/admin/users', [AdminUserController::class, 'index'])
    ->name('admin.users.index');

Route::post('/admin/users', [AdminUserController::class, 'store'])
    ->name('admin.users.store');

Route::put('/admin/users/{id}', [AdminUserController::class, 'update'])
    ->name('admin.users.update');

Route::delete('/admin/users/{id}', [AdminUserController::class, 'destroy'])
    ->name('admin.users.destroy');


// ==========================================
// JADWAL PERSONAL TRAINER ADMIN
// ==========================================

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/jadwal-pt', function (AdminScheduleController $controller) {
        abort_unless(auth()->user()->role === 'admin', 403);
        return $controller->index();
    })->name('admin.jadwal-pt.index');

    Route::put('/admin/jadwal-pt/{schedule}', function (
        \Illuminate\Http\Request $request,
        \App\Models\ScheduleLatihan $schedule,
        AdminScheduleController $controller
    ) {
        abort_unless(auth()->user()->role === 'admin', 403);
        return $controller->update($request, $schedule);
    })->name('admin.jadwal-pt.update');

    Route::delete('/admin/jadwal-pt/{schedule}', function (
        \App\Models\ScheduleLatihan $schedule,
        AdminScheduleController $controller
    ) {
        abort_unless(auth()->user()->role === 'admin', 403);
        return $controller->destroy($schedule);
    })->name('admin.jadwal-pt.destroy');
});


// ==========================================
// PROFIL ADMIN
// ==========================================

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/profil', [AdminProfileController::class, 'edit'])
        ->name('admin.profile.edit');

    Route::put('/admin/profil', [AdminProfileController::class, 'updateProfile'])
        ->name('admin.profile.update');

    Route::put('/admin/profil/password', [AdminProfileController::class, 'updatePassword'])
        ->name('admin.password.update');
});
