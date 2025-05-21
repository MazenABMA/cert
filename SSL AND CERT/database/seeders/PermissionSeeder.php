<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create add_review permission
        Permission::create(['name' => 'add_review', 'guard_name' => 'web']);
        
        // Assign permission to role if needed
        // Uncomment and modify this if you have roles in your system
        // $role = Role::findByName('user', 'web');
        // $role->givePermissionTo('add_review');
        
        // Alternatively, assign to all existing users directly
        $users = User::all();
        foreach ($users as $user) {
            $user->givePermissionTo('add_review');
        }
    }
}
