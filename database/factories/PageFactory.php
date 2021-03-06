<?php

namespace Database\Factories;

use App\Enums\PageTypeEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Page>
 */
class PageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title'   => $this->faker->word . '-' . $this->faker->date,
            'content' => $this->faker->text,
            'type'    => $this->faker->randomElement(PageTypeEnum::cases())->value,
        ];
    }
}
