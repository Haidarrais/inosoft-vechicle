<?php

namespace App\Interfaces;

interface UserRepositoryInterface 
{
    public function getAllUsers();
    public function getUserById($UserId);
    public function deleteUser($UserId);
    public function register(array $request);
    public function login(array $credentials);
    public function updateUser($UserId, array $newDetails);
}
