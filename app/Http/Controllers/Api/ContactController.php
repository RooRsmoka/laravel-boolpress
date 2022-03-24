<?php

namespace App\Http\Controllers\Api;

use App\Contact;
use App\Http\Controllers\Controller;
use App\Mail\NewContactMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class ContactController extends Controller
{
    public function store(Request $request) {
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'message' => 'required|string',
            'attachment' => 'nullable|file'
        ]);

        $contact = new Contact();
        $contact->fill($data);

        if (key_exists('attachment', $data)) {
            $contact->attachment = Storage::put('contactAttachments', $data['attachment']);
        }

        $contact->save();

        Mail::to('admin@gmail.com')->send(new NewContactMail($contact));

        return response()->json($contact);
    }
}
