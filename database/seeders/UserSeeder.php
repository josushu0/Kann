<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => config('auth.admin.name'),
            'email' => config('auth.admin.email'),
            'avatar' => 'https://gravatar.com/avatar/'.hash('sha256', strtolower(trim(config('auth.admin.email')))).'?s=200&d=identicon',
            'password' => Hash::make(config('auth.admin.password')),
        ]);

        $user->assignRole('admin');
    }
}
