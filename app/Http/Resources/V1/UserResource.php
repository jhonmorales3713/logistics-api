<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use App\Models\UserRole;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    {
        // dd ($this);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
            'status' => $this->status,
            'createdAt' => $this->created_at,
            'roles' => UserRoleFragment::collection($this->userRoles),
            'canActive' => $this->status == UserRole::STATUS_INACTIVE,
            'canInactive' => $this->status == UserRole::STATUS_ACTIVE,
        ];
    }
}
