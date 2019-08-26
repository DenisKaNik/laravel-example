<?php

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()['cache']->forget('spatie.permission.cache');

        Model::unguard();

        $siteAccessPermission = new Permission([
            'name' => 'access admin',
        ]);
        $siteAccessPermission->save();

        // init roles
        foreach (['user', 'admin', 'moderator'] as $role) {
            if ($role == 'admin') {
                $adminRole = new Role(['name'  => 'admin']);
                $adminRole->save();
                $adminRole->givePermissionTo('access admin');
            } else {
                Role::create(['name' => $role]);
            }
        }

        $usersToExist = [
            'user' => [
                [
                    'name' => 'user',
                    'email' => 'user@example.com',
                    'password' => 'user$486*okm',
                ],
            ],
            'admin' => [
                [
                    'name' => 'SuperAdmin',
                    'email' => 'admin@example.com',
                    'password' => 'Admin#poi@123',
                ],
            ],
            'moderator' => [
                [
                    'name' => 'moderatorA',
                    'email' => 'moderatorA@example.com',
                    'password' => 'Rm@ZX$20p6T',
                ],
                [
                    'name' => 'moderatorB',
                    'email' => 'moderatorB@example.com',
                    'password' => '8PtD$7U!a5',
                ],
            ],
        ];

        foreach ($usersToExist as $role => $users) {
            foreach ($users as $user) {
                $model = User::where([
                    'name' => $user['name'],
                    'email'=> $user['email'],
                ])->first();

                if (!$model) {
                    echo("creating user with {$user['email']} : {$user['password']}\n");

                    $model = new User([
                        'name' => $user['name'],
                        'email' => $user['email'],
                        'password' => bcrypt($user['password'])
                    ]);
                    $model->save();

                    $model->assignRole($role);
                }
            }
        }

        Model::reguard();
    }
}
