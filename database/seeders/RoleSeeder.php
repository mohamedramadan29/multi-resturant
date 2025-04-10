<?php

namespace Database\Seeders;

use App\Models\dashboard\Role;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permisions = [];
        foreach (config('permissions') as $key => $value) {
            $permisions[] = $key;
        }
        Role::create([
            'role' => 'مدير عام',
            'permission' => json_encode($permisions)
        ]);
    }
}
