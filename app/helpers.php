<?php
use App\Models\Movie;
use Illuminate\Support\Facades\Log;


if (!function_exists('calculateRentalOptions')) {
    function calculateRentalOptions(Movie $movie) {
        $release_date = $movie->release_date; // example: 25 de Agosto de 1979
        $rating = $movie->rating;
        $popularity = $movie->popularity;
        $daily_rate = $movie->pricing_per_day;
        
        $discount = 0.00;

        $date_parts = explode(' ', $release_date);
        $year = intval(end($date_parts));

        if ($year < 2020) {
            $discount += (2020 - $year) * 0.013;
        }
        if ($rating > 4) {
            $discount += 0.03;
        }
        if ($popularity > 100) {
            $discount += 0.05;
        }
        Log::info("Desconto: ");
        Log::info($discount);
        $value = $daily_rate * (1.00 - $discount);
        return [
            [
                'name' => 'Um dia',
                'duration' => 1,
                'original_price' => number_format($daily_rate, 0) - 0.01,
                'discount_price' => number_format($value * 1, 0) - 0.01,
                'discount_percentage' => $discount * 100,
                'type' => 'COMMON',
                'description' => 'Alugue por um dia e seja feliz!'
            ],
            [
                'name' => 'Três dias',
                'duration' => 3,
                'original_price' => number_format($daily_rate * 3, 0) - 0.01,
                'discount_price' => number_format($value * 0.90 * 3, 0) - 0.01,
                'discount_percentage' => $discount * 100,
                'type' => 'COMMON',
                'description' => 'Alugue por três dias 10% de desconto!'
            ],
            [
                'name' => 'Uma semana',
                'duration' => 7,
                'original_price' => number_format($daily_rate * 7, 0) - 0.01,
                'discount_price' => number_format($value * 0.70 * 7, 0) - 0.01,
                'discount_percentage' => $discount * 100,
                'type' => 'COMMON',
                'description' => 'Alugue por uma semana 30% de desconto!'
            ],
            [
                'name' => 'Duas semanas',
                'duration' => 14,
                'original_price' => number_format($daily_rate * 14, 0) - 0.01,
                'discount_price' => number_format($value * 0.50 * 14, 0) - 0.01,
                'discount_percentage' => $discount * 100,
                'type' => 'COMMON',
                'description' => 'Alugue por duas semanas 50% de desconto!'
            ]
        ];
    }
}