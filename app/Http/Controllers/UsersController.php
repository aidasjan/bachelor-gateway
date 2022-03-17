<?php

namespace App\Http\Controllers;

use App\Mail\PasswordResetMail;
use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Support\Facades\Mail;

class UsersController extends Controller
{

    public function __construct(UserService $userService)
    {
        $this->middleware('auth')->except(['showPasswordReset', 'sendPasswordReset', 'resetPassword']);
        $this->userService = $userService;
    }

    public function index()
    {
        if (auth()->user()->isAdmin()) {
            $users = $this->userService->all();
            return view('pages.admin.users.index')->with('users', $users);
        } else abort(404);
    }

    public function create()
    {
        if (auth()->user()->isAdmin()) {
            return view('pages.admin.users.register');
        } else return abort(404);
    }

    public function store(Request $request)
    {
        if (auth()->user()->isAdmin()) {
            $this->validateStoreRequest($request);
            $randomPassword = $this->userService->store($request);

            $data = array(
                'newUserEmail' => $request->input('email'),
                'newUserPassword' => $randomPassword
            );

            return redirect('register')->with($data);
        } else abort(404);
    }

    private function validateStoreRequest(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255']
        ]);
    }

    public function password()
    {
        if (auth()->user()->isNewClient() || auth()->user()->isClient() || auth()->user()->isAdmin()) {
            return view('pages.users.password');
        } else abort(404);
    }

    public function passwordChange(Request $request)
    {
        if (auth()->user()->isNewClient() || auth()->user()->isClient() || auth()->user()->isAdmin()) {
            $this->validatePasswordChangeRequest($request);
            $this->userService->changePassword($request);
            return redirect('/dashboard');
        } else abort(404);
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
        if (auth()->user()->isAdmin()) {
            $user = $this->userService->find($id);
            if ($user === null) abort(404);
            return view('pages.admin.users.edit')->with('user', $user);
        } else abort(404);
    }

    public function update(Request $request, $id)
    {
        if (auth()->user()->isAdmin()) {
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

    public function destroy($id)
    {
        if (auth()->user()->isAdmin()) {
            $user = $this->userService->destroy($id);
            if ($user === null) abort(404);
            return redirect('/users');
        } else abort(404);
    }
}
