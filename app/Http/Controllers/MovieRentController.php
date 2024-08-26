<?php

namespace App\Http\Controllers;

use App\Models\MovieRent;
use App\Models\Movie;
use DB;
use App\Models\User;
use Illuminate\Http\Request;

class MovieRentController extends Controller {
    public function recent(Request $request) {
        $days = $request->query('days', 7);
        $movies_rent = MovieRent::where('rented_at', '>=', now()->subDays($days))->get();
        $movies = [];
        $query = "
        SELECT R.rented_at, M.title, M.genre, M.id as movie_id, U.name as username, U.id as user_id, U.email as user_email 
        FROM movie_rents R 
        INNER JOIN movies M ON M.id = R.movie_id 
        INNER JOIN users U ON U.id = R.user_id
        WHERE R.rented_at >= ?
        ";
        $movies_rent = DB::select($query, [now()->subDays($days)]);
        return response()->json($movies_rent);
    }
    public function byUser(Request $request) {
        $user = $request->user();
        $userId = $user->id;
        $movies_rent = MovieRent::where([
            ['user_id', $userId],
            ['returned_at', null]
        ])->get();
        $movies = Movie::whereIn('id', $movies_rent->pluck('movie_id'))->get();
        return response()->json($movies);
    }
    public function rent(Request $request) {
        $movieRent = new MovieRent();
        $request->validate([
            'movie_id' => 'required|exists:movies,id'
        ], [
            'movie_id.required' => 'O filme é obrigatório',
            'movie_id.exists' => 'O filme não existe'
        ]);
        $movieRent->user_id = $request->user()->id;
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