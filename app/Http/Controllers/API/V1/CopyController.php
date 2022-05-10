<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\CopyCollection;
use App\Http\Resources\V1\CopyResource;
use App\Models\Copy;
use App\Models\User;
use Illuminate\Http\Request;

class CopyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $userId = auth()->user()->id;

        return new CopyCollection(Copy::all()->where('user_id', '=', $userId));
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



    public function indexUserCopies(User $user)
    {
        return new CopyCollection(Copy::all()->where('user_id', '=', $user->id));
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
