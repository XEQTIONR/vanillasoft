<?php

namespace App\Http\Controllers;

use App\Jobs\SendEmailJob;

use App\Models\Email;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    //

    public function list(Request  $request) {
        $validated = $request->validate([
            'api_key' => 'required'
        ]);

        return Email::with('attachments')->get();
    }

    public function send(Request $request) {

        $validated = $request->validate([
            'api_key' => 'required',
            'emails' => 'required'
        ]);



        $emails = $request->input('emails');

        foreach ($emails as $email) {
            SendEmailJob::dispatch($email);
        }



        return response('Sending Emails', 201);

    }
}
