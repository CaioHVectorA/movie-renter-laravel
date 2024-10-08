<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MovieController extends Controller {
    public function index(Request $request) {
        $page = $request->query('page', 1);
        $limit = 20;
        $movies = Movie::paginate($limit, ["*"], 'page', $page);
        return response()->json($movies);
    }
    public function show($id) {
        // convert id string to id integer
        $movie = Movie::find((int)$id);
        if (!$movie) {
            return response()->json(['message' => 'Movie not found'], 404);
        }
        Log::info('Movie found: ', ["movie" => $movie->pricing_per_day]);
        $response = [
            'movie' => $movie,
            'rental_options' => calculateRentalOptions($movie)
        ];
        return response()->json($response);
    }
    public function create(Request $request) {
        $movie = new Movie();
        $request->validate([
            'title' => 'required',
            'director' => 'required',
            'release_date' => 'required|date',
            'genre' => 'required'
        ], [
            'release_date.required' => 'A data de lançamento é obrigatória',
            'release_date.date' => 'A data de lançamento deve ser uma data válida',
            'title.required' => 'O título é obrigatório',
            'director.required' => 'O diretor é obrigatório',
            'genre.required' => 'O gênero é obrigatório'
        ]);
        $movie->title = $request->input('title');
        $movie->director = $request->input('director');
        $movie->release_date = $request->input('release_date');
        $movie->genre = $request->input('genre');
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
