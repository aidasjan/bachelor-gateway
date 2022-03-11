<?php

namespace App\Http\Controllers;

use App\Services\CompanyService;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function __construct(CompanyService $companyService)
    {
        $this->companyService = $companyService;
    }

    public function index() {
        $compnaies = $this->companyService->all();
        return view('pages.companies.index')->with('companies', $compnaies);
    }
}
