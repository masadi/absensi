<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Yajra\Acl\Models\Role;
use Yajra\Acl\Models\Permission;
use App\Models\User;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $resource = 'Users';
        $group = Str::title($resource);
        $slug = Str::slug($group);
        $system = false;
        $permissions = [
            [
                'slug' => 'viewAny-'.$slug,
                'resource' => $group,
                'name' => 'View Any '.$group,
                'system' => $system,
            ],
            [
                'slug' => 'view-'.$slug,
                'resource' => $group,
                'name' => 'View '.$group,
                'system' => $system,
            ],
            [
                'slug' => 'create-'.$slug,
                'resource' => $group,
                'name' => 'Create '.$group,
                'system' => $system,
            ],
            [
                'slug' => 'update-'.$slug,
                'resource' => $group,
                'name' => 'Update '.$group,
                'system' => $system,
            ],
            [
                'slug' => 'delete-'.$slug,
                'resource' => $group,
                'name' => 'Delete '.$group,
                'system' => $system,
            ],
        ];
        foreach ($permissions as $permission) {
            Permission::updateOrCreate($permission);
        }
        $roles = ['admin', 'ptk', 'siswa'];
        foreach($roles as $role){
            $admin = Role::updateOrCreate([
                'name' => Str::title($role),
                'slug' => Str::slug($role),
                'system' => true,
                'description' => "$role role.",
            ]);
            $admin->grantPermission(3);
        }
        $akun = ['admin@smkariyametta.sch.id', 'ptk@gmail.com', 'siswa@gmail.com'];
        User::whereIn('email', $akun)->delete();
        $user = User::updateOrCreate(
            [
                'name' => 'Administrator',
                'email' => 'admin@smkariyametta.sch.id',
            ],
            [
                'password' => bcrypt(12345678),
            ]
        );
        //$user->grantPermissionBySlug('create-users');
        $user->attachRoleBySlug('admin');
        $user = User::updateOrCreate(
            [
                'name' => 'PTK',
                'email' => 'ptk@gmail.com',
            ],
            [
                'password' => bcrypt(12345678),
            ]
        );
        //$user->grantPermissionBySlug('view-users');
        $user->attachRoleBySlug('ptk');
        $user = User::updateOrCreate(
            [
                'name' => 'Siswa',
                'email' => 'siswa@gmail.com',
            ],
            [
                'password' => bcrypt(12345678),
            ]
        );
        //$user->grantPermissionBySlug('view-users');
        $user->attachRoleBySlug('siswa');
        $this->call(IndoRegionSeeder::class);
    }
}
