<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\ContactSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public function index()
    {
        $contactSettings = ContactSetting::getSettings();
        return view('pages.contact', compact('contactSettings'));
    }

public function submit(Request $request)
{
    try {
        $validated = $request->validate([
            'con_name' => 'required|string|max:255',
            'con_email' => 'required|email|max:255',
            'con_phone' => 'nullable|string|max:20',
            'con_message' => 'required|string|max:5000',
        ]);

        $contact = Contact::create([
            'name' => $validated['con_name'],
            'email' => $validated['con_email'],
            'phone' => $validated['con_phone'] ?? null,
            'message' => $validated['con_message'],
        ]);

        try {
            if (config('mail.from.address')) {
                Mail::to(config('mail.from.address'))
                    ->send(new \App\Mail\ContactFormSubmitted($contact));
                
                Mail::to($contact->email)
                    ->send(new \App\Mail\ContactFormAutoReply($contact));
            }
        } catch (\Exception $e) {
            Log::error('Contact email error: ' . $e->getMessage());
        }

        // Redirect with URL parameters (GUARANTEED TO WORK)
        return redirect()->route('contact', [
            'submitted' => 'success',
            'name' => $validated['con_name']
        ]);

    } catch (\Illuminate\Validation\ValidationException $e) {
        return redirect()->back()->withErrors($e->validator)->withInput();
    } catch (\Exception $e) {
        Log::error('Contact form error: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Something went wrong.')->withInput();
    }
}
}