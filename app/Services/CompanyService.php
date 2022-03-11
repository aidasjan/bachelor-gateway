<?php

namespace App\Services;

use App\Models\Company;

class CompanyService
{
    public function all()
    {
        return Company::all();
    }
}
