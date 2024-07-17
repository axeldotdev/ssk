<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /** @return array<string, mixed> */
    public function toArray(Request $request): array
    {
        return [
            'uuid' => $this->uuid,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'fullname' => $this->fullname,
            'email' => $this->email,
            'phone' => $this->phone,
            'country' => $this->country,
            'locale' => $this->locale,
            'timezone' => $this->timezone,
            'verified_at' => $this->verified_at,
            'onboarded_at' => $this->onboarded_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'companies' => CompanyResource::collection($this->whenLoaded('companies')),
        ];
    }
}
