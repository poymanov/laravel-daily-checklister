<?php

namespace Database\Factories;

use App\Models\ChecklistGroup;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ChecklistGroup>
 */
class ChecklistGroupFactory extends Factory
{
    protected $model = ChecklistGroup::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word() . '-' . $this->faker->date,
        ];
    }
}
