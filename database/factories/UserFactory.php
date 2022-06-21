<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory{

    protected $model = User::class;

    public function definition(){      

        $dominios = [
            '@gmail.com', 
            '@clicko.es', 
            '@outlook.es', 
        ];

        $email = strtolower($this->faker->firstname.'_'.$this->faker->lastName.rand(0, 100).$dominios[rand(0, count($dominios)-1)]);

        if( !User::where('email', $email)->first() ){

            return [
                'name'              => $this->faker->name,
                'email'             => $email,
                'email_verified_at' => now(),
                'password'          => Hash::make(12345678),
                'remember_token'    => Str::random(10),
                'api_token'         => Str::random(60),
            ];
        }  
    }
}
