<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\UserRole;
use Illuminate\Http\Request;
use App\Http\Requests\StoreuserRoleRequest;
use App\Http\Requests\UpdateUserRoleRequest;
use App\Services\UserRoleService;
use App\Http\Resources\V1\UserRoleResource;

class UserRoleController extends Controller
{
    protected $userRoleService;
    public function __construct(UserRoleService $userRoleService)
    {
        $this->userRoleService = $userRoleService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return $this->userRoleService->getAllUserRoles($request);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRoleRequest $request)
    {
        return new UserRoleResource(UserRole::create($request->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id)
    {
        if ($id) {
            $userRole = UserRole::where('id', $id)->first();
            if ($userRole) {
                return new UserRoleResource($userRole);
            }
            throw ValidationException::withMessages(['error' => 'No user role Found']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function dropdown(Request $request)
    {
        $userRole = UserRole::where('name','like', '%'.$request->input('name').'%')->limit(10)->get();
        if ($userRole) {
            return $userRole;
        }
        throw ValidationException::withMessages(['error' => 'No user role Found']);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(userRole $userRole)
    {
        //
    }
    public function setInactive(Request $request, $id)
    {
        if ($id) {
            $userRole = UserRole::where('id', $id)->first();
            
            $this->authorize('inactive', $userRole);
            $userRole->status = UserRole::STATUS_INACTIVE;
            $userRole->save();
            return new UserRoleResource($userRole, $this);
        }
    }
    public function setActive(Request $request, $id)
    {
        if ($id) {
            $userRole = UserRole::where('id', $id)->first();
            
            $this->authorize('active', $userRole);
            $userRole->status = UserRole::STATUS_ACTIVE;
            $userRole->save();
            return new UserRoleResource($userRole, $this);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRoleRequest $request, $id)
    {
        $userRole = UserRole::find($id);
        $userRole->update($request->all());

        return new UserRoleResource($userRole);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserRole $userRole)
    {
        //
    }
}
