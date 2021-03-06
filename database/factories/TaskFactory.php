<?php

namespace Database\Factories;

use App\Models\Checklist;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name'         => $this->faker->words(3, true) . '-' . $this->faker->date . '-' . $this->faker->time,
            'description'  => $this->faker->text,
            'checklist_id' => Checklist::factory(),
            'order'        => $this->faker->randomDigit(),
        ];
    }
}
