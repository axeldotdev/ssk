<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CompanyResource;
use App\Models\Company;
use Illuminate\Http\Request;

class SwitchCompanyController extends Controller
{
    public function update(Request $request, Company $company): CompanyResource
    {
        $request->user()->forceFill([
            'current_company_id' => $company->id,
        ])->saveQuietly();

        return new CompanyResource($company);
    }
}
