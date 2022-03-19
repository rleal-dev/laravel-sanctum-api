<?php

namespace App\Http\Controllers;

use App\Http\Resources\PermissionCollection;
use Illuminate\Http\Response;
use Spatie\Permission\Models\{Permission, Role};
use Throwable;

class RolePermissionController extends BaseApiController
{
    /**
     * Show the permissions of role.
     *
     * @OA\Get(
     *   path="/roles/{id}/permissions",
     *   tags={"Role"},
     *   operationId="rolePermissionIndex",
     *   summary="List permissions of roles",
     *   description="List permissions of roles",
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     description="Role Id",
     *     required=true,
     *     @OA\Schema(type="integer")
     *   ),
     *   @OA\Response(response=200, description="Successful Operation"),
     *   @OA\Response(response=404, description="Resource Not Found"),
     *   security={{"passport": {}}},
     * )
     *
     * @param \Spatie\Permission\Models\Role $role
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Role $role)
    {
        return new PermissionCollection($role->permissions);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @OA\Post(
     *   path="/roles/{role_id}/permissions/{permission_id}",
     *   tags={"Role"},
     *   operationId="rolePermissionStore",
     *   summary="Attach permissions to role",
     *   description="Attach permissions to role",
     *   @OA\Parameter(
     *     name="role_id",
     *     in="path",
     *     description="Role Id",
     *     required=true,
     *     @OA\Schema(type="integer")
     *   ),
     *   @OA\Parameter(
     *     name="permission_id",
     *     in="path",
     *     description="Permission Id",
     *     required=true,
     *     @OA\Schema(type="integer")
     *   ),
     *   @OA\Response(response=201, description="Created Successful"),
     *   @OA\Response(response=400, description="Bad Request"),
     *   @OA\Response(response=500, description="Server Error"),
     *   security={{"passport": {}}},
     * )
     *
     * @param \Spatie\Permission\Models\Role $role
     * @param \Spatie\Permission\Models\Permission $permission
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Role $role, Permission $permission)
    {
        try {
            $role->givePermissionTo($permission);
        } catch (Throwable $exception) {
            throw_if(is_development(), $exception);

            return $this->responseError('Error on save permission!');
        }

        return $this->response(
            'Permission saved successfully!',
            [],
            Response::HTTP_CREATED
        );
    }

    /**
     * Update a newly created resource in storage.
     *
     * @OA\Update(
     *   path="/roles/{role_id}/permissions/{permission_id}",
     *   tags={"Role"},
     *   operationId="rolePermissionUpdate",
     *   summary="Sync permissions to role",
     *   description="Sync permissions to role",
     *   @OA\Parameter(
     *     name="role_id",
     *     in="path",
     *     description="Role Id",
     *     required=true,
     *     @OA\Schema(type="integer")
     *   ),
     *   @OA\Parameter(
     *     name="permission_id",
     *     in="path",
     *     description="Permission Id",
     *     required=true,
     *     @OA\Schema(type="integer")
     *   ),
     *   @OA\Response(response=201, description="Created Successful"),
     *   @OA\Response(response=400, description="Bad Request"),
     *   @OA\Response(response=500, description="Server Error"),
     *   security={{"passport": {}}},
     * )
     *
     * @param \Spatie\Permission\Models\Role $role
     * @param \Spatie\Permission\Models\Permission $permission
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Role $role, Permission $permission)
    {
        if ($role->hasPermissionTo($permission)) {
            return $this->destroy($role, $permission);
        }

        return $this->store($role, $permission);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @OA\Delete(
     *   path="/roles/{role_id}/roles/{permission_id}",
     *   tags={"Role"},
     *   operationId="rolePermissionDestroy",
     *   summary="Remove role permission",
     *   description="Remove role permission",
     *   @OA\Parameter(
     *     name="role_id",
     *     in="path",
     *     description="Role Id",
     *     required=true,
     *     @OA\Schema(type="integer")
     *   ),
     *   @OA\Parameter(
     *     name="permission_id",
     *     in="path",
     *     description="Permission Id",
     *     required=true,
     *     @OA\Schema(type="integer")
     *   ),
     *   @OA\Response(response=201, description="Created Successful"),
     *   @OA\Response(response=400, description="Bad Request"),
     *   @OA\Response(response=500, description="Server Error"),
     *   security={{"passport": {}}},
     * )
     *
     * @param \Spatie\Permission\Models\Role $role
     * @param \Spatie\Permission\Models\Permission $permission
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Role $role, Permission $permission)
    {
        try {
            $role->revokePermissionTo($permission);
        } catch (Throwable $exception) {
            throw_if(is_development(), $exception);

            return $this->responseError('Error on delete permission!');
        }

        return $this->response('Permission deleted successfully!');
    }
}
