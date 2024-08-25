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
    public function byUser(Request $request, $userId) {
        $movies = MovieRent::where('user_id', $userId)->get();
        return response()->json($movies);
    }
    public function rent(Request $request) {
        $movieRent = new MovieRent();
        $movieRent->user_id = $request->input('user_id');
        $movieRent->movie_id = $request->input('movie_id');
        $movieRent->rented_at = now();
        $movieRent->save();
        return response()->json($movieRent);
    }
    public function return(Request $request, $id) {
        $movieRent = MovieRent::find($id);
        if (!$movieRent) {
            return response()->json(['message' => 'Movie rent not found'], 404);
        }
        $movieRent->returned_at = now();
        $movieRent->save();
        return response()->json($movieRent);
    }
}  