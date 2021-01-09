<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Notifications\InboxMessage;
use App\Admin;
use App\Http\Controllers\Controller;
//use App\Mail\ContactMail;

use Illuminate\Http\Request;
use Illuminate\Mail\Mailer;
use Illuminate\Validation\Rules\In;

class ContactController extends Controller
{

    public function postContact(ContactRequest $message, Admin $admin)
    {
        $admin->notify(new InboxMessage($message));
    }
}
