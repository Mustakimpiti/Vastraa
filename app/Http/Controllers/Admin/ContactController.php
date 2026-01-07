<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
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
        $request->validate([
            'admin_reply' => 'required|string|min:10',
        ]);

        $contact = Contact::findOrFail($id);
        
        // Update contact with reply
        $contact->markAsReplied($request->admin_reply);

        // Send email to customer
        try {
            Mail::to($contact->email)->send(new ContactReplyMail($contact));
            $message = 'Reply sent successfully to customer.';
        } catch (\Exception $e) {
            $message = 'Reply saved but email failed to send: ' . $e->getMessage();
        }

        return redirect()->back()->with('success', $message);
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