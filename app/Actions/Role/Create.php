<?php

namespace App\Actions\Role;

use App\Http\Requests\RoleRequest;
use App\Models\Role;

class Create
{
    /**
     * Create a role
     *
     * @param RoleRequest $request
     *
     * @return Role
     */
    public function execute(RoleRequest $request): Role
    {
        return Role::create($request->validated());
    }
}
