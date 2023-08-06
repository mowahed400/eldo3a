<?php

namespace Database\Factories;

use App\Enums\CategoryState;
use App\Models\Section;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $faker_ar = \Faker\Factory::create('ar_SA');

        return [
            'name' => ['en' => $this->faker->name(), 'ar' => $faker_ar->unique()->name()],
            'description' => ['en' => $this->faker->text(), 'ar' => $faker_ar->unique()->text()],
            'color' => $this->faker->hexColor(),
            'section_id' => Section::inRandomOrder()->first()->id,
            'state' => CategoryState::ACTIVE,
        ];
    }
}
