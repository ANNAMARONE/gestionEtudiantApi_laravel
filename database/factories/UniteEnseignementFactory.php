<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UniteEnseignement>
 */
class UniteEnseignementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'date_debut' => $this->faker->date,
            'dat_fin' => $this->faker->date,
            'coef' => $this->faker->numberBetween(1, 10),
            'libelle' => $this->faker->word,
        ];
    }
}
