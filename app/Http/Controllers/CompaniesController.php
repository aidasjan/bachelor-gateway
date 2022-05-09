<?php

namespace App\Http\Controllers;

use App\Services\CompanyService;
use App\Services\UserService;
use Illuminate\Http\Request;

class CompaniesController extends Controller
{
    public function __construct(CompanyService $companyService, UserService $userService)
    {
        $this->companyService = $companyService;
        $this->userService = $userService;
    }

    public function index()
    {
        $companies = $this->companyService->all();
        $user = auth()->user();
        if ($user && ($user->isAdmin() || $user->isClient())) {
            $accessToken = $this->userService->setAccessToken($user->id);
            return view('pages.companies.index')->with(['companies' => $companies, 'accessToken' => $accessToken, 'userId' => $user->id]);
        }
        return view('pages.companies.index')->with('companies', $companies);
    }

    public function create()
    {
        if (auth()->user()->isSuperAdmin()) {
            return view('pages.companies.create');
        } else return abort(404);
    }

    public function store(Request $request)
    {
        if (auth()->user()->isSuperAdmin()) {
            $this->validateStoreRequest($request);
            $this->companyService->store($request);
            return redirect('/');
        } else abort(404);
    }

    private function validateStoreRequest(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:255'],
            'webpage_url' => ['required', 'string', 'max:255'],
            'portal_url' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
        ]);
    }

    public function edit($id)
    {
        if (auth()->user()->isSuperAdmin()) {
            $company = $this->companyService->find($id);
            if ($company === null) {
                abort(404);
            }
            return view('pages.companies.edit')->with('company', $company);
        } else return abort(404);
    }

    public function update(Request $request, $id)
    {
        if (auth()->user()->isSuperAdmin()) {
            $this->validateStoreRequest($request);
            $this->companyService->update($request, $id);
            return redirect('/');
        } else abort(404);
    }

    public function disable($id)
    {
        if (auth()->user()->isSuperAdmin()) {
            $this->companyService->disable($id);
            return redirect('/');
        } else abort(404);
    }
}
