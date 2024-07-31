<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ListCompanyRequest;
use App\Http\Requests\Api\StoreCompanyRequest;
use App\Http\Requests\Api\UpdateCompanyRequest;
use App\Http\Resources\CompanyResource;
use App\Models\Company;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;

class CompanyController extends Controller
{
    public function index(ListCompanyRequest $request): ResourceCollection
    {
        return CompanyResource::collection(Company::paginate());
    }

    public function store(StoreCompanyRequest $request): CompanyResource
    {
        $company = Company::create($request->validated());

        return new CompanyResource($company);
    }

    public function show(Company $company): CompanyResource
    {
        return new CompanyResource($company);
    }

    public function update(UpdateCompanyRequest $request, Company $company): CompanyResource
    {
        if ($request->has('owner')) {
            $company->owner()->associate($request->input('owner'));
        }

        $company->update([
            'name' => $request->input('name', $company->name),
        ]);

        return new CompanyResource($company);
    }

    public function destroy(Company $company): Response
    {
        $company->delete();

        return response()->noContent();
    }
}
