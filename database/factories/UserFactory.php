<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    public function definition()
    {
        $email = $this->faker->unique()->safeEmail;
        return [
            'name' => encrypt($this->faker->name),
            'email' => encrypt($email),
            'role' => encrypt('admin'),
            'email_h' => hash('sha1', $email),
            'password' => '',
            'remember_token' => Str::random(10),
        ];
    }
}
