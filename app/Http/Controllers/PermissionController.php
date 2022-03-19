<?php

namespace App\Http\Controllers;

use App\Http\Requests\PermissionRequest;
use App\Http\Resources\{PermissionCollection, PermissionResource};
use App\Models\Permission;
use Illuminate\Http\{Request, Response};
use Throwable;

class PermissionController extends BaseApiController
{
    /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     *   path="/permissions",
     *   tags={"Permission"},
     *   operationId="permissionIndex",
     *   summary="List of permissions",
     *   description="List of permissions",
     *   @OA\Response(response=200, description="Successful Operation"),
     *   @OA\Response(response=400, description="Bad Request"),
     *   @OA\Response(response=500, description="Server Error"),
     *   security={{"passport": {}}},
     * )
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $permissions = Permission::filter($request->all())
            ->orderBy('name')
            ->paginate();

        return new PermissionCollection($permissions);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @OA\Post(
     *   path="/permissions",
     *   tags={"Permission"},
     *   operationId="permissionStore",
     *   summary="Create a new permission",
     *   description="Create a new permission",
     *   @OA\RequestBody(
     *     @OA\MediaType(
     *       mediaType="application/json",
     *       @OA\Schema(
     *         @OA\Property(property="name", type="string"),
     *         example={
     *           "name": "Show Profile",
     *         }
     *       )
     *     )
     *   ),
     *   @OA\Response(response=201, description="Created Successful"),
     *   @OA\Response(response=400, description="Bad Request"),
     *   @OA\Response(response=422, description="Unprocessable Entity"),
     *   @OA\Response(response=500, description="Server Error"),
     *   security={{"passport": {}}},
     * )
     *
     * @param  PermissionRequest  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(PermissionRequest $request)
    {
        try {
            $permission = Permission::create($request->validated());
        } catch (Throwable $exception) {
            throw_if(is_development(), $exception);

            return $this->responseError('Error on create permission!');
        }

        return $this->response(
            'Permission updated successfully!',
            new PermissionResource($permission),
            Response::HTTP_CREATED
        );
    }

    /**
     * Display the specified resource.
     *
     * @OA\Get(
     *   path="/permissions/{id}",
     *   tags={"Permission"},
     *   operationId="permissionShow",
     *   summary="Show permission",
     *   description="Show permission",
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     description="Permission Id",
     *     required=true,
     *     @OA\Schema(type="integer")
     *   ),
     *   @OA\Response(response=200, description="Successful Operation"),
     *   @OA\Response(response=404, description="Resource Not Found"),
     *   security={{"passport": {}}},
     * )
     *
     * @param \Spatie\Permission\Models\Permission $permission
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Permission $permission)
    {
        return new PermissionResource($permission);
    }

    /**
     * Update the specified resource in storage.
     *
     * @OA\Put(
     *   path="/permissions/{id}",
     *   tags={"Permission"},
     *   operationId="permissionUpdate",
     *   summary="Update permission",
     *   description="Update permission",
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     description="Permission Id",
     *     required=true,
     *     @OA\Schema(type="integer")
     *   ),
     *   @OA\RequestBody(
     *     @OA\MediaType(
     *       mediaType="application/json",
     *       @OA\Schema(
     *         @OA\Property(property="name", type="string"),
     *         example={
     *           "name": "Update Profile",
     *          }
     *        )
     *     )
     *   ),
     *   @OA\Response(response=200, description="Successful Operation"),
     *   @OA\Response(response=404, description="Resource Not Found"),
     *   @OA\Response(response=422, description="Unprocessable Entity"),
     *   @OA\Response(response=500, description="Server Error"),
     *   security={{"passport": {}}},
     * )
     *
     * @param PermissionRequest  $request
     * @param \Spatie\Permission\Models\Permission $permission
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(PermissionRequest $request, Permission $permission)
    {
        try {
            $permission->update($request->validated());
        } catch (Throwable $exception) {
            throw_if(is_development(), $exception);

            return $this->responseError('Error on update permission!');
        }

        return $this->response(
            'Permission updated successfully!',
            new PermissionResource($permission)
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @OA\Delete(
     *   path="/permissions/{id}",
     *   tags={"Permission"},
     *   operationId="permissionDestroy",
     *   summary="Destroy permission",
     *   description="Destroy permission",
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     description="Permission Id",
     *     required=true,
     *     @OA\Schema(type="integer")
     *   ),
     *   @OA\Response(response=200, description="Successful Operation"),
     *   @OA\Response(response=404, description="Resource Not Found"),
     *   @OA\Response(response=422, description="Unprocessable Entity"),
     *   @OA\Response(response=500, description="Server Error"),
     *   security={{"passport": {}}},
     * )
     *
     * @param \Spatie\Permission\Models\Permission $permission
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Permission $permission)
    {
        try {
            $permission->delete();
        } catch (Throwable $exception) {
            throw_if(is_development(), $exception);

            return $this->responseError('Error on delete permission!');
        }

        return $this->response('Permission deleted successfully!');
    }
}
