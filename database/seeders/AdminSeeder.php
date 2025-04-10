<?php

namespace Database\Seeders;

use App\Models\dashboard\Role;
use App\Models\dashboard\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $first_role_id = Role::first()->id;
        $admin = Admin::create([
            "name"=> "mohamed",
            "email"=> "mr319242@gmail.com",
            'phone' => '01000000000',
            "password"=> bcrypt("11111111"),
            'type'=>'superadmin',
            'role_id' => $first_role_id
        ]);
    }
}
