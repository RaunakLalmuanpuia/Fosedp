<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{

    public function run()
    {
        $USERS = [
            ['id'=>1,'name'=>'planning','email'=>'planning@email.com','mobile'=>'0000000001','password'=>Hash::make('password')],
        ];

        User::query()->upsert($USERS, ['id']);

    }
}
