<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre_apellido' => fake()->name(),
            'identificacion' => fake()->unique()->numerify('##########'),
            'correo' => fake()->unique()->safeEmail(),
            'password' => static::$password ??= Hash::make('password'),
            'telefono' => fake()->numerify('##########'),
            'genero' => fake()->randomElement(['Masculino', 'Femenino', 'Otro']),
            'etnia' => fake()->randomElement(['Ninguna', 'Indígena', 'Afrodescendiente', 'Mestizo']),
            'discapacidad' => fake()->randomElement(['Ninguna', 'Visual', 'Auditiva', 'Motriz']),
        ];
    }
}
