<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Models\Inquiry;
use Illuminate\Http\Request;

class UserRoleService
{
    public function getAllUserRoles(Request $request)
    {
        $page = (int)($request->query('page') ?? 1 ) - 1;

        $limit = $request->query('limit') ?? 15; 
        $search = $request->query('search');
        $orderBy = $request->query('sortBy') ?? '-user_roles.id';
        // filters
        $status = $request->query('status');
        // end of filters
        $userRoles = DB::table('user_roles')
            ->leftJoin('user_user_role', 'user_user_role.user_role_id', '=', 'user_roles.id')
            ->leftJoin('users', 'user_user_role.user_id', '=', 'users.id')
            ->select('user_roles.*',DB::raw('count(user_user_role.user_id) as userCount'))
            ->groupBy(
                'user_roles.name',
                'user_roles.id',
                'user_roles.access',
                'user_roles.status',
                'user_roles.created_by',
                'user_roles.updated_at',
                'user_roles.created_at'
            );
        if ($search != '') {
            $userRoles->where('user_roles.name', 'like', "%{$search}%" );
        }
        if($status) {
            $userRoles->where('user_roles.status', '=', "$status" );
        }
        $order = substr($orderBy, 0, 1) == '-' ? 'desc' : 'asc';
        $column = $order == 'desc' ? substr($orderBy, 1, strlen($orderBy)) : $orderBy;
        if ($column == 'name') {
            $column = 'user_roles.name';
        }
        $userRoles->orderBy($column, $order);
        $totalRows = $userRoles->count();
        $userRoles = $userRoles->limit($limit)->offset($page * $limit)->get();
        $userRoleList = [];
        
        foreach ($userRoles as $userRole) {
            $userRoleList[] = [
                'id' => $userRole->id,
                'name' => $userRole->name,
                'status' => $userRole->status,
                'userCount' => $userRole->userCount,
                'createdAt' => $userRole->created_at,
            ];
        }
        return [
            'totalRows' => $totalRows,
            'page' => $page + 1,
            'limit' => $limit,
            'data' => $userRoleList
        ];
    }
}