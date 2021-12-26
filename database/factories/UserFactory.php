<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected $model = User::class;

  /**
   * Define the model's default state.
   *
   * @return array
   */
  public function definition()
  {
    return [
      'name' => $this->faker->name,
      'email' => $this->faker->unique()->safeEmail,
      'email_verified_at' => now(),
      'password' => '$2y$10$o8JH6DfUp9xfbj8uZbeDlODqRz2I9raeu6nPZf59rPHY8dfBhwo9e', // password
      'remember_token' => Str::random(10),
      'api_token' => Str::random(80)
    ];
  }

  public function predefinedState()
  {
    return $this->state([
      'name' => 'John Doe',
      'email' => 'john@doe.com',
      'password' => '$2y$10$o8JH6DfUp9xfbj8uZbeDlODqRz2I9raeu6nPZf59rPHY8dfBhwo9e', // password
      'is_admin' => true,
    ]);
  }
}
