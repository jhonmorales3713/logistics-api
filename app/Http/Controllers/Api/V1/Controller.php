<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Services\UserRoleService;
use App\Policies\Policies;

class Controller extends BaseController
{
    protected $userRole;
    public function __construct() {
    }
    use AuthorizesRequests, ValidatesRequests;
    public function hasPermission($permission) {
        
        $user = Auth::user();
        $userRoles = DB::table('users')
                    ->join('user_user_role', 'users.id', '=', 'user_user_role.user_id')
                    ->join('user_roles', 'user_user_role.user_role_id', '=', 'user_roles.id')
                    ->where('users.id', $user->id)
                    ->select('user_roles.*')
                    ->get();
        $permit = $userRoles->filter(function ($data) use($permission) {
            $permits = explode(',', $data->access);
            // echo $permission;
            return in_array($permission, $permits); // Filter elements greater than 2
        });
        return count($permit) > 0 || $user->id == 1;
    }
}
