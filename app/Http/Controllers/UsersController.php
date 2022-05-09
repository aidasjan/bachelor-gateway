<?php

namespace App\Http\Controllers;

use App\Services\CompanyService;
use Illuminate\Http\Request;
use App\Services\UserService;

class UsersController extends Controller
{

    public function __construct(UserService $userService, CompanyService $companyService)
    {
        $this->middleware('auth')->except(['showPasswordReset', 'sendPasswordReset', 'resetPassword']);
        $this->userService = $userService;
        $this->companyService = $companyService;
    }

    public function index()
    {
        if (auth()->user()->isSuperAdmin()) {
            $users = $this->userService->all();
            return view('pages.admin.users.index')->with('users', $users);
        } else abort(404);
    }

    public function create()
    {
        if (auth()->user()->isSuperAdmin()) {
            $companies = $this->companyService->all();
            return view('pages.admin.users.create')->with('companies', $companies);
        } else return abort(404);
    }

    public function store(Request $request)
    {
        if (auth()->user()->isSuperAdmin()) {
            $this->validateStoreRequest($request);
            $this->userService->store($request);
            return redirect('users');
        } else abort(404);
    }

    private function validateStoreRequest(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'company_id' => ['required', 'numeric']
        ]);
    }

    public function password()
    {
        return view('pages.users.password');
    }

    public function passwordChange(Request $request)
    {
        $this->validatePasswordChangeRequest($request);
        $this->userService->changePassword($request);
        return redirect('/dashboard');
    }

    private function validatePasswordChangeRequest(Request $request)
    {
        $this->validate($request, [
            'password' => ['required', 'string', 'min:8', 'max:255', 'confirmed']
        ]);
    }

    public function showPasswordReset()
    {
        return view('pages.users.password_reset');
    }

    public function sendPasswordReset(Request $request)
    {
        $this->validateResetPasswordRequest($request);
        $this->userService->sendPasswordReset($request->input('email'));
        return redirect('/');
    }

    public function resetPassword($token)
    {
        $result = $this->userService->resetPassword($token);
        if ($result === null) {
            abort(401);
        }
        return redirect('/password');
    }

    private function validateResetPasswordRequest(Request $request)
    {
        $this->validate($request, [
            'email' => ['required', 'email']
        ]);
    }

    public function edit($id)
    {
        if (auth()->user()->isSuperAdmin()) {
            $user = $this->userService->find($id);
            if ($user === null) abort(404);
            return view('pages.admin.users.edit')->with('user', $user);
        } else abort(404);
    }

    public function update(Request $request, $id)
    {
        if (auth()->user()->isSuperAdmin()) {
            $this->validateUpdateRequest($request);
            $user = $this->userService->update($request, $id);
            if ($user == null) abort(404);
            return redirect('/users');
        } else abort(404);
    }

    private function validateUpdateRequest(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255']
        ]);
    }

    public function disable($id)
    {
        if (auth()->user()->isSuperAdmin()) {
            $this->userService->disable($id);
            return redirect('/users');
        } else abort(404);
    }
}
