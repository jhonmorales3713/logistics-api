<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\StoreuserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Services\UserService;
use App\Http\Resources\V1\UserResource;

class UserController extends Controller
{
    protected $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return $this->userService->getAllUsers($request);
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
    public function store(StoreUserRequest $request)
    {
        return new UserResource(User::create($request->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id)
    {
        if ($id) {
            $user = User::where('id', $id)->first();
            if ($user) {
                return new UserResource($user);
            }
            throw ValidationException::withMessages(['error' => 'No user role Found']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function dropdown(Request $request)
    {
        $user = User::where('name','like', '%'.$request->input('name').'%')->get();
        if ($user) {
            return $user;
        }
        throw ValidationException::withMessages(['error' => 'No user role Found']);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(user $user)
    {
        //
    }
    public function setInactive(Request $request, $id)
    {
        if ($id) {
            $user = User::where('id', $id)->first();
            
            $this->authorize('inactive', $user);
            $user->status = User::STATUS_INACTIVE;
            $user->save();
            return new UserResource($user, $this);
        }
    }
    public function setActive(Request $request, $id)
    {
        if ($id) {
            $user = User::where('id', $id)->first();
            
            $this->authorize('active', $user);
            $user->status = User::STATUS_ACTIVE;
            $user->save();
            return new UserResource($user, $this);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $user = User::find($id);
        $validatedData = $request->validated();
        $roles = $validatedData['userRoles'];
        
        // Sync roles for the user
        $user->userRoles()->sync($roles);

        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
