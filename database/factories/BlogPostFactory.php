<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BlogPostFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array
   */
  public function definition()
  {
    return [
      'title' => $this->faker->sentence(2),
      'content' => $this->faker->realText(900),
      'created_at' => $this->faker->dateTimeBetween('-3 months')
    ];
  }

  public function determineData(array $state)
  {
    return $this->state($state);
  }
}
