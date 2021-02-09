<?php

namespace App\Http\Controllers;

use App\Mail\SendEmail;
use Illuminate\Support\Facades\Mail;

use Illuminate\Http\Request;

class EmailController extends Controller
{
    //
    public function send(Request $request) {


        $validated = $request->validate([
            'api_key' => 'required',
            'emails' => 'required'
        ]);



        $emails = $request->input('emails');

        foreach ($emails as $email) {
            Mail::to($this->email['to'])->send(new SendEmail($this->email));
        }



        return response($validated, 201);
        //return $validated;

    }
}
