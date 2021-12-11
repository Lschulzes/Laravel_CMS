<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $usersCount = max((int)$this->command->ask('Users Quantity', 5), 1);
    User::factory()->predefinedState()->create();
    User::factory($usersCount)->create();
  }
}
