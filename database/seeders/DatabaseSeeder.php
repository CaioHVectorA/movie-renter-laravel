<?php

namespace Database\Seeders;
use App\Models\Movie;
use App\Models\MovieRent;
use Faker\Factory as Faker;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void {
        $faker = Faker::create();

        foreach (range(1, 200) as $index) {
            User::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'password' => bcrypt('password'),
            ]);
        }
        // foreach (range(1, 200) as $index) {
        //     Movie::create([
        //         'title' => $faker->sentence(3),
        //         'director' => $faker->name,
        //         'release_date' => $faker->date(),
        //         'genre' => $faker->word,
        //     ]);
        // }
        $movies = Movie::all();
        $users = User::all();
        foreach (range(1, 200) as $index) {
            MovieRent::create([
                'movie_id' => $movies->random()->id,
                'user_id' => $users->random()->id,
                'rented_at' => $faker->dateTimeBetween('-1 year', 'now'),
                'returned_at' => $faker->dateTimeBetween('now', '+1 year'),
            ]);
        }
    }
}
