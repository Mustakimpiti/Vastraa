<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\ContactReplyMail;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        $query = Contact::query()->latest();

        // Filter by status
        if ($request->has('status')) {
            switch ($request->status) {
                case 'unread':
                    $query->unread();
                    break;
                case 'read':
                    $query->read();
                    break;
                case 'replied':
                    $query->replied();
                    break;
            }
        }

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }

        $contacts = $query->paginate(15);

        return view('admin.contacts.index', compact('contacts'));
    }

    public function markAsRead($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->markAsRead();

        return redirect()->back()->with('success', 'Contact marked as read.');
    }

    public function markAsUnread($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->update(['status' => 'unread']);

        return redirect()->back()->with('success', 'Contact marked as unread.');
    }

    public function reply(Request $request, $id)
    {
        Log::info('=== CONTACT REPLY STARTED ===');
        Log::info('Contact ID: ' . $id);
        
        try {
            // Validate
            $validated = $request->validate([
                'admin_reply' => 'required|string|min:10',
            ]);
            
            Log::info('Validation passed');
            
            // Find contact
            $contact = Contact::findOrFail($id);
            Log::info('Contact found: ' . $contact->name);
            
            // Update contact with reply
            $contact->status = 'replied';
            $contact->admin_reply = $validated['admin_reply'];
            $contact->replied_at = now();
            $contact->save();
            
            Log::info('Contact updated in database');
            
            // Send email to customer
            try {
                Log::info('Attempting to send email to: ' . $contact->email);
                
                Mail::to($contact->email)->send(new ContactReplyMail($contact));
                
                Log::info('Email sent successfully');
                
                return redirect()->back()->with('success', 'Reply sent successfully to ' . $contact->email);
                
            } catch (\Symfony\Component\Mailer\Exception\TransportException $e) {
                // SMTP error
                Log::error('SMTP Error: ' . $e->getMessage());
                return redirect()->back()->with('error', 'Reply saved but email failed: SMTP error. Check your mail configuration.');
                
            } catch (\Exception $e) {
                // Other email errors
                Log::error('Email error: ' . $e->getMessage());
                return redirect()->back()->with('error', 'Reply saved but email failed: ' . $e->getMessage());
            }
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed');
            return redirect()->back()->withErrors($e->validator)->withInput();
            
        } catch (\Exception $e) {
            Log::error('Reply error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();

        return redirect()->back()->with('success', 'Contact message deleted successfully.');
    }

    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete,mark_read,mark_replied',
            'contact_ids' => 'required|array',
            'contact_ids.*' => 'exists:contacts,id'
        ]);

        $contacts = Contact::whereIn('id', $request->contact_ids);

        switch ($request->action) {
            case 'delete':
                $contacts->delete();
                $message = 'Selected contacts deleted successfully.';
                break;
            case 'mark_read':
                $contacts->update(['status' => 'read']);
                $message = 'Selected contacts marked as read.';
                break;
            case 'mark_replied':
                $contacts->update(['status' => 'replied']);
                $message = 'Selected contacts marked as replied.';
                break;
        }

        return redirect()->back()->with('success', $message);
    }
}