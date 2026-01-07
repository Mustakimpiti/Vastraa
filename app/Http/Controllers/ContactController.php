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
            // Validate the form data
            $validated = $request->validate([
                'con_name' => 'required|string|max:255',
                'con_email' => 'required|email|max:255',
                'con_phone' => 'nullable|string|max:20',
                'con_message' => 'required|string|max:5000',
            ]);

            // Create contact record
            $contact = Contact::create([
                'name' => $validated['con_name'],
                'email' => $validated['con_email'],
                'phone' => $validated['con_phone'] ?? null,
                'message' => $validated['con_message'],
            ]);

            // Try to send emails (don't fail if emails don't work)
            try {
                // Check if mail is configured
                if (config('mail.from.address')) {
                    Mail::to(config('mail.from.address'))
                        ->send(new \App\Mail\ContactFormSubmitted($contact));
                    
                    Mail::to($contact->email)
                        ->send(new \App\Mail\ContactFormAutoReply($contact));
                }
            } catch (\Exception $e) {
                // Log email error but continue
                Log::error('Contact email error: ' . $e->getMessage());
            }

            // Create success message
            $successMessage = "Thank you for contacting us, {$validated['con_name']}! We have received your message and will respond within 24-48 hours.";

            // Redirect back with success message
            return redirect()
                ->route('contact')
                ->with([
                    'success' => $successMessage,
                    'alert_type' => 'success',
                    'contact_submitted' => true
                ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Validation failed - redirect back with errors
            return redirect()
                ->back()
                ->withErrors($e->validator)
                ->withInput();
                
        } catch (\Exception $e) {
            // Something went wrong
            Log::error('Contact form error: ' . $e->getMessage());
            
            return redirect()
                ->back()
                ->with('error', 'Something went wrong. Please try again.')
                ->withInput();
        }
    }
}