<?php

namespace Database\Seeders;


use App\Modules\User\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = file_get_contents(__DIR__ . '/data/users.json');
        $users = (json_decode($data, true));

        foreach ($users as $user){

            $userData = [
                'name' => Arr::get($user, 'name'),
                'last_name' => Arr::get($user, 'lastname'),
                'email' => Arr::get($user, 'email'),
                'phone' => Arr::get($user, 'phone'),
                'password' => bcrypt(Arr::get($user, 'password')),
                'remember_token' => Str::random(10),
                'group_id' => Arr::get($user, 'group_id'),
            ];

            User::firstOrCreate(['email' => Arr::get($user, 'email'), 'phone' => Arr::get($user, 'phone')],
                $userData);





        }

    }

}
