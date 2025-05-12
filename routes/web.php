<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DonationController;

Route::get('/', [DonationController::class, 'showForm'])->name('donation.form');
Route::post('/donate', [DonationController::class, 'processDonation'])->name('donation.process');