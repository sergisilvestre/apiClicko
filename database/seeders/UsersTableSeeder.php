<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\User;

class UsersTableSeeder extends Seeder{


    public function run(){

        \App\Models\User::factory(20)->create();
    }
}
