<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;

class MovieController extends Controller {
    public function index() {
        $movies = Movie::all();
        return response()->json($movies);
    }
    public function create(Request $request) {
        $movie = new Movie();
        $movie->title = $request::input('title');
        $movie->director = $request::input('director');
        $movie->releaseDate = $request::input('release_date');
        $movie->genre = $request::input('genre');
        $movie->save();
        return response()->json($movie);
    }
    public function update(Request $request, $id) {
        $movie = Movie::find($id);
        if (!$movie) {
            return response()->json(['message' => 'Movie not found'], 404);
        }
        $movie->title = $request->input('title') ?? $movie->title;
        $movie->director = $request->input('director') ?? $movie->director;
        $movie->releaseDate = $request->input('release_date') ?? $movie->releaseDate;
        $movie->genre = $request->input('genre') ?? $movie->genre;
        $movie->save();
        return response()->json($movie);
    }
    public function delete($id) {
        $movie = Movie::find($id);
        if (!$movie) {
            return response()->json(['message' => 'Movie not found'], 404);
        }
        $movie->delete();
        return response()->json(['message' => 'Movie deleted']);
    }
}
