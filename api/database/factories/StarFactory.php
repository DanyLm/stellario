<?php

namespace Database\Factories;

use App\Models\Star;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Http\Services\FileService;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Star>
 */
class StarFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Model>
     */
    protected $model = Star::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'description' => fake()->text(400),
            'face' => FileService::jsonMetadata('public/face-' . rand(1, 5) . '.png'),
            'popularity' => rand(1, 100)
        ];
    }
}
