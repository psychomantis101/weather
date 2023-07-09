<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmailOptInRequest;

class EmailController extends Controller
{
    public function index()
    {
        $optIn = auth()->user()->email_opt_in;

        return view('emailOptIn', compact('optIn'));
    }

    public function optIn(EmailOptInRequest $request)
    {
        auth()->user()->update(['email_opt_in' => $request->optIn]);

        return redirect()->back()->with('message', 'Email Opt In Updated!');
    }
}
