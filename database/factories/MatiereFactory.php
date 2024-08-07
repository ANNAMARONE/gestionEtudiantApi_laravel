<?php

namespace Database\Factories;

use App\Models\UniteEnseignement;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Matiere>
 */
class MatiereFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'libelle' => $this->faker->word,
            'date_debut' => $this->faker->date,
            'dat_fin' => $this->faker->date,
            'unite_enseignement_id' => UniteEnseignement::factory()
            
        ];
    }
}
