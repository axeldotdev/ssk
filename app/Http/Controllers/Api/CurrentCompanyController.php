<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CompanyResource;
use Illuminate\Http\Request;

class CurrentCompanyController extends Controller
{
    public function show(Request $request): CompanyResource
    {
        return new CompanyResource($request->user()->currentCompany);
    }

    public function update(Request $request): CompanyResource
    {
        $request->user()->currentCompany->update($request->validated());

        return new CompanyResource($request->user()->currentCompany);
    }
}
