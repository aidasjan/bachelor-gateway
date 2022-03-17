<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (auth()->user()->isNewClient()) return redirect('/password');

        if (auth()->user()->isAdmin() || auth()->user()->isClient()) {
            return view('pages.users.dashboard');
        };
    }
}
