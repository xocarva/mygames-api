<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\CopyCollection;
use App\Http\Resources\V1\CopyResource;
use App\Models\Copy;
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
        return new CopyCollection(Copy::all());
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
            'userId'        => ['integer', 'required'],
            'gameId'        => ['integer','required'],
            'platformId'    => ['integer','required'],
            'rating'        => ['integer', 'min:1', 'max:5'],
            'completed'     => ['boolean'],

        ]);

        $copy = Copy::create([
            'user_id'       => $request->input('userId'),
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
        return (new CopyResource($copy))
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
        $this->validate($request, [
            'userId'        => ['integer'],
            'gameId'        => ['integer'],
            'platformId'    => ['integer'],
            'rating'        => ['integer', 'min:1', 'max:5'],
            'completed'     => ['boolean']
        ]);

        $copy->update([
            'user_id'       => $request->input('userId') ?? $copy->user_id,
            'game_id'       => $request->input('gameId') ?? $copy->game_id,
            'platform_id'   => $request->input('platformId') ?? $copy->platform_id,
            'rating'        => $request->input('rating') ?? $copy->rating,
            'completed'     => $request->input('completed') ?? $copy->completed,
        ]);

        return (new CopyResource($copy))
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
        $copy->delete();

        return response()->json(null, 204);
    }
}
