<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        
        // Create and seed roles
        $adminRole = Role::create(['name' => 'admin']);
        $moderatorRole = Role::create(['name' => 'moderator']);
        $brotherRole = Role::create(['name' => 'brother']);

        $listPostsPermission = Permission::create(['name' => 'list posts']);
        $deletePostsPermission = Permission::create(['name' => 'delete posts']);

        $adminRole->givePermissionTo($listPostsPermission);
        $moderatorRole->givePermissionTo($listPostsPermission);
        $brotherRole->givePermissionTo($listPostsPermission);

        $adminRole->givePermissionTo($deletePostsPermission);
        $brotherRole->givePermissionTo($deletePostsPermission);
        

        // Create base users
        $userAdmin = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('adminuhuy'),
        ]);
        $userAdmin->assignRole('admin', 'brother');

        $userModerator = User::create([
            'name' => 'Moderator',
            'email' => 'moderator@gmail.com',
            'password' => bcrypt('moderatoruhuy'),
        ]);
        $userModerator->assignRole('moderator', 'brother');

        $userBrother = User::create([
            'name' => 'Brother',
            'email' => 'brother@gmail.com',
            'password' => bcrypt('brotheruhuy'),
        ]);
        $userBrother->assignRole('brother');
       

        $userTest = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('testuhuy'),
        ]);
        $userTest->assignRole('brother');
    }
}
