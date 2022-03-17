<?php

namespace App\Http\Controllers;

use App\Services\CompanyService;
use App\Services\UserService;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function __construct(CompanyService $companyService, UserService $userService)
    {
        $this->companyService = $companyService;
        $this->userService = $userService;
    }

    public function index() {
        $compnaies = $this->companyService->all();
        $user = auth()->user();
        if ($user) {
            $accessToken = $this->userService->setAccessToken($user->id);
            return view('pages.companies.index')->with(['companies' => $compnaies, 'accessToken' => $accessToken, 'userId' => $user->id]);
        }
        return view('pages.companies.index')->with('companies', $compnaies);
    }
}
