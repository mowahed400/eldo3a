<?php

namespace Database\Factories;

use App\Enums\SectionState;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Section>
 */
class SectionFactory extends Factory
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
            'name' => ['en' => $this->faker->name(), 'ar' => $faker_ar->name()],
            'description' => ['en' => $this->faker->text(), 'ar' => $faker_ar->text()],
//            'color' => $this->faker->hexColor(),
            'state' => SectionState::ACTIVE,
            'settings' => [
                'has_margins' => random_int(1,2),
            ]
        ];
    }
}
