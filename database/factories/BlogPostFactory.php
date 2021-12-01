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
      'content' => $this->faker->realText()
    ];
  }

  public function determineData(array $state)
  {
    return $this->state($state);
  }
}
