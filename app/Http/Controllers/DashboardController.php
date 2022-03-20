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
        $user = auth()->user();

        if ($user->isNewClient() || $user->isNewAdmin()) return redirect('/password');

        if ($user->isAdmin() || $user->isClient() || $user->isSuperAdmin()) {
            return view('pages.users.dashboard');
        };
    }
}
