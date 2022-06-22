<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\GameCollection;
use App\Http\Resources\V1\GameResource;
use App\Models\Game;
use Illuminate\Http\Request;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new GameCollection(Game::paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title'     => ['string', 'required', 'max:50'],
            'genreId'   => ['integer', 'required'],
            'studioId'  => ['integer', 'required'],
        ]);

        $games = Game::select('games.*')
            ->where('title', $request->title)
            ->where('genre_id', $request->genreId)
            ->where('studio_id', $request->studioId)
            ->get();

        if(count($games) > 0) {
            return response()->json([
                'error' => [
                    'message' => 'Game already exists',
                ],
            ],422);
        }

        $game = Game::create([
            'title'     => $request -> input('title'),
            'genre_id'  => $request->input('genreId'),
            'studio_id' => $request->input('studioId'),
        ]);

        return (new GameResource($game))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function show(Game $game)
    {
        return (new GameResource($game))
            ->response()
            ->setStatusCode((200));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Game $game)
    {
        $this->validate($request, [
            'title'     => ['string','max:50'],
            'genreId'   => ['integer'],
            'studioId'  => ['integer'],
        ]);

        $games = Game::select('games.*')
            ->where('title', $request->title)
            ->where('genre_id', $request->genreId)
            ->where('studio_id', $request->studioId)
            ->get();

        if(count($games) > 0) {
            return response()->json([
                'error' => [
                    'message' => 'Game already exists',
                ],
            ],422);
        }

        $game->update([
            'title'     => $request->input('title') ?? $game->title,
            'genre_id'  => $request->input('genreId') ?? $game->genre_id,
            'studio_id' => $request->input('studioId') ?? $game->studio_id,
        ]);

        return (new GameResource($game))
            ->response()
            ->setStatusCode(200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function destroy(Game $game)
    {
        $game->delete();

        return response()->json(null, 204);
    }
}
