<?php

namespace App\Http\Controllers;

use App\Models\MovieRent;
use Illuminate\Http\Request;

class MovieRentController extends Controller {
    public function recent(Request $request) {
        $days = $request->query('days', 7);
        $movies = MovieRent::where('created_at', '>=', now()->subDays($days))->get();
        return response()->json($movies);
    }
}  