<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;

class DonationController extends Controller
{
    public function showForm()
    {
        return view('donation');
    }

    public function processDonation(Request $request)
    {
        // Validate request
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'amount' => 'required',
        ]);

        $amount = $request->amount === 'other' ? 5000 : intval($request->amount) * 100;

        Stripe::setApiKey(env('STRIPE_SECRET'));

        $session = StripeSession::create([
            'payment_method_types' => ['card'],
            'customer_email' => $request->email,
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => 'Mission Donation',
                    ],
                    'unit_amount' => $amount,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('donation.form') . '?success=true',
            'cancel_url' => route('donation.form') . '?cancel=true',
        ]);

        return redirect($session->url);
    }
}
