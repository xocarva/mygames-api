<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\UserCollection;
use App\Http\Resources\V1\UserResource;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function index()
    {
        return new UserCollection(User::all());
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'name'      => ['string', 'required', 'min:2', 'max:50'],
            'email'     => ['email', 'required', 'max:50', 'unique:users'],
            'password'  => ['string', 'required', 'min:8', 'max:12']
        ]);

        $user = User::create([
            'name'      => $request -> input('name'),
            'email'     => $request -> input('email'),
            'password'  => $request ->input('password'),
        ]);

        return (new UserResource($user))
            ->response()
            ->setStatusCode(201);
    }


    public function show(User $user)
    {
        return (new UserResource($user))
            ->response()
            ->setStatusCode((200));
    }


    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'name'      => ['string', 'min:2', 'max:50'],
            'email'     => ['email', 'max:50', Rule::unique('users')->ignore($user->email)],
            'password'  => ['string', 'min:8', 'max:12'],
            'admin'     => ['boolean'],

        ]);

        $user->update([
            'name'      => $request->input('name') ?? $user->name,
            'email'     => $request->input('email') ?? $user->email,
            'password'  => Hash::make($request->password) ?? $user->password,
            'admin'   => $request->input('admin') ?? $user->admin,
        ]);

        return (new UserResource($user))
            ->response()
            ->setStatusCode(200);
    }


    public function destroy(User $user)
    {
        $user->delete();

        return response()->json(null, 204);

    }
}
