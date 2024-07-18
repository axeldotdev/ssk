<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class CompanyController extends Controller
{
    public function index(Request $request): Response
    {
        return Inertia::render('Companies/Index', [
            'filters' => $request->only('name'),
            'companies' => Company::query()
                ->select('uuid', 'name', 'user_id')
                ->with(['owner' => function (Builder $query) {
                    $query->select('id', 'email', 'fullname');
                },
                ])
                ->when(
                    $request->filled('name'),
                    fn ($query) => $query->where(
                        'name',
                        'like',
                        "%{$request->input('name')}%",
                    )
                )
                ->orderBy('name')
                ->paginate(25),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Companies/Create');
    }

    public function show(Company $company): Response
    {
        return Inertia::render('Companies/Show', [
            'company' => $company,
        ]);
    }

    public function update(Request $request, Company $company): RedirectResponse
    {
        $company->update($request->all());

        return Redirect::route('companies.edit');
    }
}
