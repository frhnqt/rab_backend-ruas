<?php

namespace App\Repositories;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class UserRepository
{

    public function getAll()
    {
        return User::all();
    }


    public function findById($id)
    {
        return User::find($id);
    }


    public function create(array $data)
    {
        $data['password'] = Hash::make($data['password']);

        return User::create($data);
    }

    public function update($id, array $data)
    {
    $user = User::findOrFail($id);

    $user->update($data);

    return $user;
    }


public function delete($id)
    {
    $user = User::findOrFail($id);

    return $user->delete();
    }

}