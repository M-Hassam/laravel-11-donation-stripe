<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Product;
use Stripe\Price;
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
            'donation_type' => 'required|in:one-time,monthly'
        ]);

        $amount = $request->amount === 'other' ? $request->other_amount : $request->amount;
        $amountInCents = intval(floatval($amount) * 100);

        Stripe::setApiKey(env('STRIPE_SECRET'));

        if ($request->donation_type === 'monthly') {
            // Create a product
            $product = Product::create([
                'name' => 'Monthly Mission Donation',
            ]);

            // Create a price for the product (recurring monthly)
            $price = Price::create([
                'product' => $product->id,
                'unit_amount' => $amountInCents,
                'currency' => 'usd',
                'recurring' => [
                    'interval' => 'month',
                ],
            ]);

            // Create subscription session
            $session = StripeSession::create([
                'payment_method_types' => ['card'],
                'customer_email' => $request->email,
                'line_items' => [[
                    'price' => $price->id,
                    'quantity' => 1,
                ]],
                'mode' => 'subscription',
                'success_url' => route('donation.form') . '?success=true',
                'cancel_url' => route('donation.form') . '?cancel=true',
                'metadata' => [
                    'donor_name' => $request->name,
                    'donor_email' => $request->email,
                    'mission' => $request->mission,
                    'anonymous' => $request->anonymous ? 'true' : 'false'
                ]
            ]);
        } else {
            // One-time payment
            $session = StripeSession::create([
                'payment_method_types' => ['card'],
                'customer_email' => $request->email,
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => 'Mission Donation',
                        ],
                        'unit_amount' => $amountInCents,
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => route('donation.form') . '?success=true',
                'cancel_url' => route('donation.form') . '?cancel=true',
                'metadata' => [
                    'donor_name' => $request->name,
                    'donor_email' => $request->email,
                    'mission' => $request->mission,
                    'anonymous' => $request->anonymous ? 'true' : 'false'
                ]
            ]);
        }

        return redirect($session->url);
    }
}
