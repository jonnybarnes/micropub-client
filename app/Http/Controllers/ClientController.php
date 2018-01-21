<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Traits\ParseSyndicationTargets;

class ClientController extends Controller
{
    use ParseSyndicationTargets;

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
        $user = Auth::user();
        $syndicationTargets = $this->parseSyndicationTargets($user->syndication_targets);

        return view('client.note', ['targets' => $syndicationTargets]);
    }
}
