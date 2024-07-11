<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\Company;
use App\Models\Member;
use App\Models\User;

class MemberController extends Controller
{
    public function index(Company $company): UserResource
    {
        return new UserResource(Member::users($company)->paginate());
    }

    public function store(Company $company, User $user): UserResource
    {
        Member::createFor($company, $user);

        return new UserResource($user);
    }

    public function destroy(Company $company, User $user): UserResource
    {
        Member::for($company, $user)->delete();

        return new UserResource($user);
    }
}
