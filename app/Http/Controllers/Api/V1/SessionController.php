<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\V1\UserResource;
use Session;

class SessionController extends Controller
{
    public function authenticate(Request $request)
    {
        return response()->json(['loggedIn' => Session::get("loggedIn")]);
    }
    public function logout(Request $request)
    {
        Auth::logout();
    }
    public function login(Request $request)
    {
        try {
            // Validate incoming request data
            $credentials = $request->validate([
                'username' => 'required',
                'password' => 'required',
            ]);
            // Attempt to authenticate the user
            if (Auth::guard('api')->attempt($credentials)) {
                $user = Auth::user();
                if ($user->id != 1) {
                    $userRoles = DB::table('users')
                    ->join('user_user_role', 'users.id', '=', 'user_user_role.user_id')
                    ->join('user_roles', 'user_user_role.user_role_id', '=', 'user_roles.id')
                    ->where('users.id', $user->id)
                    ->select('user_roles.*')
                    ->get();
                } else {
                    $userRoles = '*';
                }
                $token = $user->createToken('auth_token')->plainTextToken;
                // echo $user;
                return response()->json(['user' => $user, 'access_token' => $token, 'user_role' => $userRoles]);
                // return response()->json(['user' => $user, 'access_token' => $token]);
            }
            // Authentication failed
            return response()->json(['error' => 'Unauthorized'], 401);
        } catch (ValidationException $e) {
            // Handle validation errors
            return response()->json(['errors' => $e->errors()], 422);
        }
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(Request $request)
    {
        
        return new UserResource(User::create($request->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $food)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
