<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $role= ['ROLE_ADMIN', 'ROLE_AFFRETEUR', 'ROLE_SOCIETE_TRANSPORT', 'ROLE_TRANSPORTEUR_INDEPENDANT'];
        $email= ['user@gmail.com', 'affreteur@gmail.com', 'societe@gmail.com', 'transporteur@gmail.com'];

        return [
            'username'=>$this->faker->unique()->userName(),
            'lastname'=>$this->faker->lastName,
            'firstname'=>$this->faker->firstName(),
            'telephone'=>$this->faker->unique()->phoneNumber,
            'adresse'=>$this->faker->address,
            'status'=>'CREATED',
            'is_condition'=>true,
            'role' => $role[array_rand($role)],
            'email' => $email[array_rand($email)],
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
