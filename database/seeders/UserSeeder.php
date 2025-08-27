<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::create([
            'name' => 'Admin User',
            'email' => 'admin@blogscript.com',
            'password' => \Hash::make('password'),
            'role' => 'admin',
            'status' => 'approved',
            'approved_at' => now(),
            'verification_status' => 'verified',
        ]);

        \App\Models\User::create([
            'name' => 'Test Artist',
            'email' => 'artist@test.com',
            'password' => \Hash::make('password'),
            'role' => 'artist',
            'status' => 'approved',
            'approved_at' => now(),
            'verification_status' => 'unverified',
            'artist_stage_name' => 'Test Artist',
            'distribution_price' => 29.99,
        ]);

        \App\Models\User::create([
            'name' => 'Test Label',
            'email' => 'label@test.com',
            'password' => \Hash::make('password'),
            'role' => 'record_label',
            'status' => 'pending',
            'verification_status' => 'unverified',
            'distribution_price' => 49.99,
        ]);

        \App\Models\User::create([
            'name' => 'Test Listener',
            'email' => 'listener@test.com',
            'password' => \Hash::make('password'),
            'role' => 'listener',
            'status' => 'approved',
            'approved_at' => now(),
            'verification_status' => 'unverified',
        ]);
    }
}
