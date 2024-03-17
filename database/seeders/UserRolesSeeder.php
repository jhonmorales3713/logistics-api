<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use App\Models\UserRole;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class UserRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get("database/data/userRole.json");
        $userRoles = json_decode($json);
        foreach ($userRoles as $key => $value) {
            UserRole::create([
                "name" => $value->name,
                "access" => $value->access,
                "status" => $value->status,
            ]);
        };
        $user2 = User::create([
            "name" => 'Admin',
            "username" => 'admin',
            "status" => 'activ',
            "email" => 'admin@logistics.com',
            "created_at" => now(),
            "password" => Hash::make('password'),
        ]);
        $user = User::create([
            "name" => 'Warehouse',
            "username" => 'warehouse',
            "status" => 'activ',
            "email" => 'warehouse@logistics.com',
            "created_at" => now(),
            "password" => Hash::make('password'),
        ]);
        $user->userRoles()->attach(UserRole::findOrFail(1)->first(), ['created_at' => now()]);
        $user2->userRoles()->attach(UserRole::findOrFail(2)->first(), ['created_at' => now()]);
    }
}
