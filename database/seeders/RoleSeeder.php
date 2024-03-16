<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $adminRole = Role::create(['name' => 'admin']);
        $userRole = Role::create(['name' => 'student']);
        $userRole = Role::create(['name' => 'teacher']);


        $adminRole->givePermissionTo('all');
    }
}
