<?php
namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Inquiry;
use Illuminate\Http\Request;

class UserService
{
    public function getAllUsers(Request $request)
    {
        $page = (int)($request->query('page') ?? 1 ) - 1;

        $limit = $request->query('limit') ?? 15; 
        $search = $request->query('search');
        $orderBy = $request->query('sortBy') ?? '-users.id';
        // filters
        $status = $request->query('status');
        // end of filters
        $users = DB::table('users')
            // ->leftJoin('user_user_role', 'user_user_role.user_id', '=', 'users.id')
            // ->leftJoin('user_roles', 'user_user_role.user_role_id', '=', 'user_roles.id')
            // ->select('users.*','user_roles.name as role', 'user_roles.id as roleId')
            // ->groupBy(
            //     'users.name',
            //     'users.id',
            //     'users.username',
            //     'users.email',
            //     'users.password',
            //     'users.email_verified_at',
            //     'users.remember_token',
            //     'users.created_at',
            //     'users.updated_at',
            //     'users.status',
            // )
            ->where('users.id','!=', Auth::user()->id)
            ->where('users.id','!=', 1);
        if ($search != '') {
            $users->where('users.name', 'like', "%{$search}%" );
        }
        if($status) {
            $users->where('users.status', '=', "$status" );
        }
        $order = substr($orderBy, 0, 1) == '-' ? 'desc' : 'asc';
        $column = $order == 'desc' ? substr($orderBy, 1, strlen($orderBy)) : $orderBy;
        if ($column == 'name') {
            $column = 'user_roles.name';
        }
        $users->orderBy($column, $order);
        $totalRows = $users->count();
        $users = $users->limit($limit)->offset($page * $limit)->get();
        $userList = [];
        
        foreach ($users as $user) {
            $userList[] = [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'status' => $user->status,
                'createdAt' => $user->created_at,
                // 'role' => [
                //     'id' => $user->roleId ?? '',
                //     'name' => $user->role ?? '',
                // ],
            ];
        }
        return [
            'totalRows' => $totalRows,
            'page' => $page + 1,
            'limit' => $limit,
            'data' => $userList
        ];
    }
}