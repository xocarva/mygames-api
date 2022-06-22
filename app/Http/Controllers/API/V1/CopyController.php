<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\CopyCollection;
use App\Http\Resources\V1\CopyResource;
use App\Models\Copy;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CopyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $userId = auth()->user()->id;
        $title = $request->title;
        $genre = $request->genre;
        $platform = $request->platform;
        $studio = $request->studio;

        $copies = Copy::join('games', 'copies.game_id', 'games.id')
                    ->join('genres', 'games.genre_id', 'genres.id')
                    ->join('studios', 'games.studio_id', 'studios.id')
                    ->join('platforms', 'copies.platform_id', 'platforms.id')
                    ->select('copies.*')
                    ->when($title, function($query, $title){
                        $query->where('games.title', 'LIKE', "%{$title}%" );
                    })
                    ->when($genre, function($query, $genre){
                        $query->where('genres.name', 'LIKE', "%{$genre}%");
                    })
                    ->when($platform, function($query, $platform){
                        $query->where('platforms.name', 'LIKE',  "%{$platform}%");
                    })
                    ->when($studio, function($query, $studio){
                        $query->where('studios.name', 'LIKE', "%{$studio}%");
                    })
                    ->where('copies.user_id', $userId)
                    ->get();
        ;

        return new CopyCollection($copies);
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
            'gameId'        => ['integer','required'],
            'platformId'    => ['integer','required'],
            'rating'        => ['integer', 'min:1', 'max:5'],
            'completed'     => ['boolean'],
        ]);

        $userId = auth()->user()->id;


        $copies = Copy::select('copies.*')
                    ->where('user_id', $userId)
                    ->where('platform_id', $request->platformId)
                    ->where('game_id', $request->gameId)
                    ->get();

        if(count($copies) > 0) {
            return response()->json([
                'error' => [
                    'message'       => 'Copy already registered',
                ],
            ],422);
        }

        $copy = Copy::create([
            'user_id'       => $userId,
            'game_id'       => $request->input('gameId'),
            'platform_id'   => $request->input('platformId'),
            'rating'        => $request->input('rating'),
            'completed'     => $request->input('completed'),
        ]);

        return (new CopyResource($copy))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Copy  $copy
     * @return \Illuminate\Http\Response
     */
    public function show(Copy $copy)
    {

        $userId = auth()->user()->id;

        $cop = new CopyResource($copy);

        $copyOwnerId = $cop->user_id;

        if($copyOwnerId !== $userId) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401);
        }

        return ($cop)
            ->response()
            ->setStatusCode((200));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Copy  $copy
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Copy $copy)
    {

        $userId = auth()->user()->id;

        $cop = new CopyResource($copy);

        $copyOwnerId = $cop->user_id;

        if($copyOwnerId !== $userId) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401);
        }

        $this->validate($request, [
            'gameId'        => ['integer'],
            'platformId'    => ['integer'],
            'rating'        => ['integer', 'min:1', 'max:5'],
            'completed'     => ['boolean']
        ]);

        $copies = Copy::select('copies.*')
                    ->where('user_id', $userId)
                    ->where('platform_id', $request->platformId)
                    ->where('game_id', $request->gameId)
                    ->get();

        if(count($copies) > 0) {
            return response()->json([
                'error' => [
                    'message'       => 'Copy already registered',
                ],
            ],422);
        }

        $copy->update([
            'game_id'       => $request->input('gameId') ?? $copy->game_id,
            'platform_id'   => $request->input('platformId') ?? $copy->platform_id,
            'rating'        => $request->input('rating') ?? $copy->rating,
            'completed'     => $request->input('completed') ?? $copy->completed,
        ]);

        return ($cop)
            ->response()
            ->setStatusCode(200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Copy  $copy
     * @return \Illuminate\Http\Response
     */
    public function destroy(Copy $copy)
    {

        $userId = auth()->user()->id;

        $cop = new CopyResource($copy);

        $copyOwnerId = $cop->user_id;

        if($copyOwnerId !== $userId) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401);
        }

        $copy->delete();

        return response()->json(null, 204);
    }



    public function indexUserCopies(Request $request, User $user)
    {
        $genre = $request->genre;
        $platform = $request->platform;
        $game = $request->game;
        $studio = $request->studio;
        $perPage = $request->pagination;

        $copies = Copy::join('games', 'copies.game_id', 'games.id')
                    ->join('genres', 'games.genre_id', 'genres.id')
                    ->join('platforms', 'copies.platform_id', 'platforms.id')
                    ->select('copies.*')
                    ->when($genre, function($query, $genre){
                        $query->where('genres.name', $genre);
                    })
                    ->when($platform, function($query, $platform){
                        $query->where('platforms.name', $platform);
                    })
                    ->when($game, function($query, $game){
                        $query->where('platforms.name', $game);
                    })
                    ->when($studio, function($query, $studio){
                        $query->where('platforms.name', $studio);
                    })
                    ->where('user_id', '=', $user->id)
                    ->paginate($perPage ?? 10)
        ;

        return new CopyCollection($copies);
    }

    public function storeUserCopy(Request $request, User $user)
    {
        $this->validate($request, [
            'gameId'        => ['integer','required'],
            'platformId'    => ['integer','required'],
            'rating'        => ['integer', 'min:1', 'max:5'],
            'completed'     => ['boolean'],

        ]);

        $copy = Copy::create([
            'user_id'       => $user->id,
            'game_id'       => $request->input('gameId'),
            'platform_id'   => $request->input('platformId'),
            'rating'        => $request->input('rating'),
            'completed'     => $request->input('completed'),
        ]);

        return (new CopyResource($copy))
            ->response()
            ->setStatusCode(201);
    }
}
