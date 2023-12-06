<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word(),
            'stock' => $this->faker->numberBetween($min = 1, $max = 5000),
            'image' => $this->faker->image('public/disk_products', 640, 480, 'animals', false),
            'description' => $this->faker->text($maxNbChars = 200),
            'price'=> $this->faker->numberBetween($min = 1, $max = 5000),
        ];
    }


}
