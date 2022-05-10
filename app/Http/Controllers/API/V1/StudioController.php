<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\StudioCollection;
use App\Http\Resources\V1\StudioResource;
use App\Models\Studio;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StudioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new StudioCollection(Studio::all());
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
            'name' => ['string', 'required', 'max:50', 'unique:studios']
        ]);

        $studio = Studio::create([
            'name' => $request -> input('name'),
        ]);

        return (new StudioResource($studio))
            ->response()
            ->setStatusCode(201);    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Studio  $studio
     * @return \Illuminate\Http\Response
     */
    public function show(Studio $studio)
    {
        return (new StudioResource($studio))
            ->response()
            ->setStatusCode((200));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Studio  $studio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Studio $studio)
    {
        $this->validate($request, [
            'name' => ['string', 'required', 'max:50', Rule::unique('studios')->ignore($studio->name)],

        ]);

        $studio->update([
            'name' => $request->input('name'),
        ]);

        return (new StudioResource($studio))
            ->response()
            ->setStatusCode(200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Studio  $studio
     * @return \Illuminate\Http\Response
     */
    public function destroy(Studio $studio)
    {
        $studio->delete();

        return response()->json(null, 204);
    }
}
