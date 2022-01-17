<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserRepository implements UserRepositoryInterface 
{
    public function getAllUsers() 
    {
        return User::all();
    }

    public function getUserById($UserId) 
    {
        return User::findOrFail($UserId);
    }

    public function deleteUser($UserId) 
    {
        User::destroy($UserId);
    }

    public function register(array $request) 
    {
        try {
            $user = new User;
            $user->name = $request['name'];
            $user->email = $request['email'];
            $plainPassword = $request['password'];
            $user->password = app('hash')->make($plainPassword);

            $user->save();

            //return successful response
            return response()->json(['user' => $user, 'message' => 'CREATED'], 201);

        } catch (\Exception $e) {
            //return error message
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function login(array $credentials)
    {
        if (! $token = Auth::attempt($credentials)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function updateUser($UserId, array $newDetails) 
    {
        return User::whereId($UserId)->update($newDetails);
    }
    protected function respondWithToken($token)
    {
        return response()->json([
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60
        ], 200);
    }
}
