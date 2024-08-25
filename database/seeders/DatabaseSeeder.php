<?php

namespace Database\Seeders;

use App\Models\Movie;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        Movie::factory()->create([
            'title' => 'The Shawshank Redemption',
            'director' => 'Frank Darabont',
            'release_date' => '1994-09-23',
            'genre' => 'Drama',
        ]);
        Movie::factory()->create([
            'title' => 'The Godfather',
            'director' => 'Francis Ford Coppola',
            'release_date' => '1972-03-24',
            'genre' => 'Crime',
        ]);
        Movie::factory()->create([
            'title' => 'The Dark Knight',
            'director' => 'Christopher Nolan',
            'release_date' => '2008-07-18',
            'genre' => 'Action',
        ]);
        Movie::factory()->create([
            'title' => '12 Angry',
            'director' => 'Sidney Lumet',
            'release_date' => '1957-04-10',
            'genre' => 'Drama',
        ]);
    }
}
