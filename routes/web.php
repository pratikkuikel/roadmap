<?php

use App\Livewire\Auth\ForgotPassword;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\Auth\ResetPassword;
use App\Livewire\Auth\VerifyEmail;
use App\Livewire\Comment;
use App\Livewire\Home;
use App\Livewire\Roadmap;
use App\Models\Tag;
use App\Models\Timeline;
use App\Models\Vote;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Route;

Route::get('/', Home::class)
    ->name('home');

Route::get('/timeline', function () {
    // return Timeline::all();
    return Vote::all();
});

Route::get('roadmap', Roadmap::class)
    ->name('roadmap');

Route::get('roadmap/{issue_id}/comments', Comment::class)
    ->name('comments');


// Authentication Routes
Route::get('login', Login::class)
    ->middleware('guest')
    ->name('login');

Route::get('register', Register::class)
    ->middleware('guest')
    ->name('register');

Route::get('/logout', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect('/');
})->name('logout');

// email verification view
Route::get('/email/verify', VerifyEmail::class)
    ->middleware('auth', 'unverified')
    ->name('verification.notice');

// email verification confirm
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect()->route('home');
})->middleware(['auth', 'signed'])->name('verification.verify');

// forgot-password
Route::get('/forgot-password', ForgotPassword::class)->middleware('guest')->name('password.request');

// reset password
Route::get('/reset-password/{token}', ResetPassword::class)->middleware('guest')->name('password.reset');
