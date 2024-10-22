<?php

namespace Database\Factories;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use Illuminate\Database\Eloquent\Factories\Factory;
use PractiCampoUD\User;
use Illuminate\Support\Str;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Hash;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'usuario' => $this->faker->userName,
            'email' => $this->faker->unique()->safeEmail,
            'password' => Hash::make('password'), // O usa bcrypt o lo que prefieras
            'id_role' => 5, // Puedes ajustar el rango según los roles que manejes
            'id_tipo_identificacion' => 1,
            //'expedicion_identificacion' => $this->faker->date,
            'id_tipo_vinculacion' => 5,
            'id_categoria' => rand(1, 5),
            'id_estado' => 1,
            'cant_espacio_academico' => rand(1, 6),
            'id_espacio_academico_1' => rand(1, 10),
            'id_espacio_academico_2' => rand(1, 10),
            'id_espacio_academico_3' => rand(1, 10),
            'id_espacio_academico_4' => rand(1, 10),
            'id_espacio_academico_5' => rand(1, 10),
            'id_espacio_academico_6' => rand(1, 10),
            'id_programa_academico' => rand(1, 5),
            'primer_nombre' => $this->faker->firstName,
            'segundo_nombre' => $this->faker->optional()->firstName,
            'primer_apellido' => $this->faker->lastName,
            'segundo_apellido' => $this->faker->lastName,
            'telefono' => $this->faker->phoneNumber,
            'celular' => $this->faker->phoneNumber,
            'id_programa_academico_coord' => rand(1, 5),
        ];
    }
}

/*$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
    ];
});*/
