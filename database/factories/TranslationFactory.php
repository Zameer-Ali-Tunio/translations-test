<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Translation>
 */
class TranslationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'key' => $this->faker->unique()->word(),
            'translations' => [
                'en' => $this->faker->word(),
                'fr' => $this->faker->word(),
            ],
            'tags' => [
                'desktop' => $this->faker->word(),
                'mobile' => $this->faker->word(),
                'web' => $this->faker->word(),
            ],
        ];
    }
}
