<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'avatar' => 'https://gravatar.com/avatar/'.hash('sha256', strtolower(trim('test@example.com'))).'?s=200&d=identicon',
        ]);

        User::factory(100)->create();
    }
}
