<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ProductionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()
            ->withPersonalTeam()
            ->create([
                'name' => config('auth.admin.name'),
                'email' => config('auth.admin.email'),
                'password' => Hash::make(config('auth.admin.password')),
                'avatar' => sprintf('https://www.gravatar.com/avatar/%s?s=200&d=retro', hash('sha256', config('auth.admin.email'))),
                'department' => '',
                'phone' => '',
                'location' => '',
            ]);
    }
}
