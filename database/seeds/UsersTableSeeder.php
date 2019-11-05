<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name' => 'test',
                'email' => 'test@gmail.com',
                'password'  => bcrypt('123456'),
            ]
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                [
                    'email' => $user['email'],
                    'name' => $user['name'],
                ], [
                    'password'   => $user['password'],
                ]
            );
        }
    }
}
