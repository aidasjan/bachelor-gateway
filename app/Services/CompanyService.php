<?php

namespace App\Services;

use App\Exceptions\UserErrorException;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyService
{
    public function find($id)
    {
        return Company::find($id);
    }

    public function all()
    {
        return Company::where('is_disabled', false)->get();
    }

    public function store(Request $request)
    {
        $exists = Company::where('code', $request->input('code'))->exists();
        if ($exists) {
            throw new UserErrorException('This company already exists.');
            return null;
        }

        $company = new Company;
        $company->name = $request->input('name');
        $company->logo = $request->input('logo');
        $company->code = $request->input('code');
        $company->webpage_url = $request->input('webpage_url');
        $company->portal_url = $request->input('portal_url');
        $company->address = $request->input('address');
        $company->email = $request->input('email');
        $company->phone = $request->input('phone');
        $company->save();

        return $company;
    }

    public function update(Request $request, $id)
    {
        $company = Company::find($id);
        if ($company === null) {
            return null;
        } 
        $company->name = $request->input('name');
        $company->logo = $request->input('logo');
        $company->code = $request->input('code');
        $company->webpage_url = $request->input('webpage_url');
        $company->portal_url = $request->input('portal_url');
        $company->address = $request->input('address');
        $company->email = $request->input('email');
        $company->phone = $request->input('phone');
        $company->save();

        return $company;
    }

    public function disable($id)
    {
        $company = Company::find($id);
        if ($company === null) {
            return false;
        } 
        $company->is_disabled = true;
        $company->save();
        return true;
    }
}
