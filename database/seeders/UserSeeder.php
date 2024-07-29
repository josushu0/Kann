<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory(3)
            ->withPersonalTeam()
            ->sequence(
                ['name' => 'Admin', 'email' => 'admin@email.com', 'is_admin' => true],
                ['name' => 'Editor', 'email' => 'editor@email.com'],
                ['name' => 'Reader', 'email' => 'reader@email.com']
            )
            ->create();
    }
}
