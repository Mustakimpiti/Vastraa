<?php

namespace App\Http\Controllers;

use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('newsletter_error', 'Please enter a valid email address.');
        }

        $email = $request->email;

        // Check if email already exists
        $existing = NewsletterSubscriber::where('email', $email)->first();

        if ($existing) {
            if ($existing->isActive()) {
                return redirect()->back()
                    ->with('newsletter_info', 'You are already subscribed to our newsletter!');
            } else {
                // Resubscribe if previously unsubscribed
                $existing->resubscribe();
                return redirect()->back()
                    ->with('newsletter_success', 'Welcome back! You have been resubscribed to our newsletter.');
            }
        }

        // Create new subscriber
        NewsletterSubscriber::create([
            'email' => $email,
            'status' => 'active',
            'subscribed_at' => now()
        ]);

        return redirect()->back()
            ->with('newsletter_success', 'Thank you for subscribing to our newsletter!');
    }

    public function unsubscribe(Request $request)
    {
        $email = $request->email;

        $subscriber = NewsletterSubscriber::where('email', $email)->first();

        if (!$subscriber) {
            return redirect()->back()
                ->with('newsletter_error', 'Email not found in our subscribers list.');
        }

        $subscriber->unsubscribe();

        return redirect()->back()
            ->with('newsletter_success', 'You have been unsubscribed from our newsletter.');
    }
}