<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function index()
    {
        return UserResource::collection(User::paginate());
    }

    public function store(UserCreateRequest $request)
    {
        $user = User::create(
            $request->only('first_name', 'last_name', 'email')
            + ['password' => Hash::make(1234)]
        );

        return response(new UserResource($user), Response::HTTP_CREATED);
    }

    public function show($id)
    {
        return new UserResource(User::find($id));
    }

    public function update(UserUpdateRequest $request, $id)
    {
        $user = User::find($id);

        $user->update($request->only('first_name', 'last_name', 'email'));

        return \response(new UserResource($user), Response::HTTP_ACCEPTED);
    }

    public function destroy($id)
    {
        User::destroy($id);

        return \response(null, Response::HTTP_NO_CONTENT);
    }
}
