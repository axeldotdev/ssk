<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\Company;
use App\Models\User;

class MembershipController extends Controller
{
    public function index(Company $company): UserResource
    {
        return new UserResource($company->users()->paginate());
    }

    public function store(Company $company, User $user): UserResource
    {
        $company->users()->attach($user);

        return new UserResource($user);
    }

    public function destroy(Company $company, User $user): UserResource
    {
        $company->users()->detach($user);

        return new UserResource($user);
    }
}
