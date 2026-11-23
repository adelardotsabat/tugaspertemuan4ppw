<?php

namespace App\Http\Controllers;

use App\Models\Contact;

class ContactAdminController extends Controller
{
    public function index()
    {
        $contacts = Contact::latest()->paginate(10);

        return view('contacts.index', compact('contacts'));
    }

    public function show(Contact $contact)
    {
        if (! $contact->is_read) {
            $contact->is_read = true;
            $contact->save();
        }

        return view('contacts.show', compact('contact'));
    }
}