<?php

namespace AvoRed\Contact\Http\Controllers;

use AvoRed\Contact\Http\Requests\ContactRequest;
use AvoRed\Ecommerce\Models\Database\Configuration;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use AvoRed\Contact\Mails\ContactMail;
use AvoRed\Contact\Mails\ContactMailRequest;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index() {
        return view('avored-contact::contact.index');
    }

    public function send(ContactRequest $request) {
        //return $request->all();

        $configuration = new Configuration();
        $adminEmail = $configuration->getConfiguration('general_administrator_email');

        // Sent an EMail to AvoRed Administrator
        Mail::to($adminEmail)->send(new ContactMailRequest($request));

        // Sent an EMail to AvoRed Administrator
        Mail::to($request->get('email'))->send(new ContactMail());


        return redirect()->route('contact.index')->with('successNotification', 'Your Request has been sent!');
    }
}
