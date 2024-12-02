<?php

use App\Http\Controllers\PatientLoginController;
use App\Http\Controllers\AdminLoginController;
use App\Models\Appointment;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/admin', [AdminLoginController::class, 'login'])->name('admin.login');
Route::post('/login', [PatientLoginController::class, 'login'])->name('login');

// Patient Routes
Route::middleware('auth:patient')->group(function () {
    Route::get('/home', [PatientLoginController::class, '/']); // Patient dashboard
});

// Admin Routes
Route::middleware('auth:admin')->group(function () {
    Route::get('/admin', [AdminLoginController::class, 'dashboards']); // Admin dashboard
});

// Admin Login Submission
Route::post('/admin/login', function (Illuminate\Http\Request $request) {
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        if (Auth::user()->type === 'Patient') {
            Auth::logout(); // Log out the user immediately
            return back()->withErrors(['email' => 'Invalid User: This Page is Forbidden']);
        }

        // Redirect Admin or Staff to Nova Dashboard
        return redirect('/admin/dashboards/main');
    }

    // If authentication fails
    return back()->withErrors(['email' => 'The provided credentials do not match our records.']);
})->name('nova.login');

// Patient Login Submission
Route::post('/login', function (Illuminate\Http\Request $request) {
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        // Check if the user type is NOT 'Patient' (Admin or Staff trying to log in)
        if (Auth::user()->type === 'Administrator' || Auth::user()->type === 'Staff') {
            Auth::logout(); // Log out the user immediately
            return back()->withErrors(['email' => 'Invalid User']);
        }

        // Redirect Patient to the home page
        return redirect('/');
    }

    // If authentication fails
    return back()->withErrors(['email' => 'The provided credentials do not match our records.']);
})->name('login');




// Artisan helper (restricted to authenticated users for security)
Route::get('/artisan', function () {
    $result = Artisan::call(request()->param);
    return $result;
})->middleware('auth');

Auth::routes(['verify' => true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->middleware('verified');
Route::get('/chat', [App\Http\Controllers\ChatController::class, 'index'])->middleware('auth');
Route::get('/reserve/{service}', function (Request $request, Service $service) {
    return view('reserve', compact('service'));
})->middleware(['auth']);

Route::post('/reserve', function (Request $request) {
    try {
        $exists = Appointment::whereSlot($request->slot)->whereDate('date', $request->date)->exists();

        if (! $exists) {
            Appointment::create([
                'slot' => $request->slot,
                'service' => $request->service,
                'patient_id' => $request->patient_id,
                'remarks' => $request->remarks,
                'date' => $request->date,
            ]);
        } else {
            alert()->error('Error','Schedule is already taken');
            return redirect()->back();
        }


        alert()->success('Success','Appointment has been submitted');

        return back();
    } catch (Exception $e) {
        alert()->error('Please fill the form.');
        return back();
    }
});

Route::post('/cancel', function (Request $request) {
    $app = Appointment::findOrFail($request->appointment_id);
    $app->update(['status' => 'Cancelled']);
    alert()->success('Your appointment has been cancelled!');
    return back();
});

Route::get('/dental-record/{user}', function (Request $request, User $user) {
    if (! $user->dentalRecord) {
        alert()->error('No Dental Record!');
        return back();
    }
    return view('dental_record', compact('user'));
})->middleware(['auth']);

Route::get('/faq', function (Request $request) {
    return view('faq');
});

// Admin and User Notifications routes
Route::get('/admin-notifications', function () {
    return view('admin_notification');
})->middleware('auth');

Route::get('/notifications', function () {
    return view('user_notification');
})->middleware('auth');
// Mark a single notification as read
Route::post('/admin-notifications/{notification}', function ($notification) {
    $userNotification = auth()->user()->notifications()->find($notification);

    if ($userNotification) {
        $userNotification->markAsRead();
    }

    return back();
})->middleware('auth');
// Mark all notifications as read route
Route::post('/notifications/mark-all-as-read', function () {
    auth()->user()->unreadNotifications->markAsRead();
    return back();
})->name('notifications.markAllAsRead')->middleware('auth');

Route::get('/treatment-history/{user}', function (User $user) {
    if (!$user->treatments()->exists()) {
        return '<div class="alert alert-secondary text-center">No Treatment History Available</div>';
    }

    return view('treatment_history', ['user' => $user]);
})->middleware(['auth']);

Route::get('/x-ray/{user}', function (User $user) {
    if (!$user->xrays()->exists()) {
        alert()->error('No X-ray Records Found!');
        return back();
    }
    return view('x_ray', compact('user')); // Pass the correct variable
})->middleware(['auth']);
