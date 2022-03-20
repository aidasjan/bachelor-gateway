<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Exceptions\UserErrorException;
use App\Mail\PasswordResetMail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class UserService
{

    public function all()
    {
        return User::all();
    }

    public function find($id)
    {
        return User::find($id);
    }

    public function store(Request $request)
    {
        $userExists = User::where('email_h', hash('sha1', $request->input('email')))->exists();
        if ($userExists) {
            throw new UserErrorException('This user already exists.');
            return;
        }

        $user = new User;
        $user->name = encrypt($request->input('name'));
        $user->email_h = hash('sha1', $request->input('email'));
        $user->email = encrypt($request->input('email'));
        $user->role = encrypt('admin');

        $randomPassword = $this->generateRandomPassword();
        $user->password = Hash::make($randomPassword);
        $user->save();

        return $randomPassword;
    }

    public function changePassword(Request $request)
    {
        $password = $request->input('password');

        $this->validatePasswordStrength($password);

        $user = auth()->user();
        $user->password = Hash::make($password);
        $user->is_new = 0;
        $user->save();

        return $user;
    }

    private function validatePasswordStrength($password)
    {
        if (!preg_match('/[A-Za-z]/', $password) || !preg_match('/[0-9]/', $password)) {
            throw new UserErrorException(__('main.password_not_secure'));
        }
    }

    public function setAccessToken($userId)
    {
        $user = User::find($userId);
        if ($user === null) {
            return null;
        }

        $accessToken = $this->generateAccessToken();
        $user->access_token = $accessToken;
        $user->save();

        return $accessToken;
    }

    public function sendPasswordReset($email) {
        $user = User::where('email_h', hash('sha1', $email))->first();
        if ($user) {
            $token = $this->generateAccessToken();
            $user->password_reset_token = $token;
            $user->password_reset_date = Carbon::now();
            $user->save();
            Mail::to($email)->send(new PasswordResetMail($token));
        }
    }

    public function resetPassword($token) {
        $user = User::where('password_reset_token', $token)->first();
        if ($user === null || $user->password_reset_date < Carbon::now()->subDay()) {
            return null;
        }
        if ($user) {
            $user->is_new = 1;
            $user->save();
            Auth::login($user);
        }
        return $user;
    }

    private function generateRandomPassword()
    {
        return Str::random(10);
    }

    private function generateAccessToken()
    {
        return Str::random(32);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if ($user === null) {
            return null;
        }
        $user->name = encrypt($request->input('name'));
        $user->save();
        return $user;
    }

    public function disable($id)
    {
        $user = User::find($id);
        if ($user === null) {
            return false;
        }
        $user->is_disabled = 1;
        $user->save();
        return true;
    }
}
