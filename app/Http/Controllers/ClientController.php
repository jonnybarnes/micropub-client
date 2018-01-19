<?php

declare(strict_types=1);

namespace App\Http\Controllers;

class ClientController extends Controller
{
    /**
     * Only allow logged in users.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the form to create a new note.
     *
     * @return \Illuminate\View\View
     */
    public function note()
    {
        return view('client.note');
    }
}
