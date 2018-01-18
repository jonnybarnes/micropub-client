<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Either show the welcome page, or if logged in redirect to dashboard.
     *
     * @return \Illuminate\Http\Redirect|\Illuminate\View\View
     */
    public function index()
    {
        if (Auth::check()) {
            return redirect(route('dashboard'));
        }

        return view('welcome');
    }
}
