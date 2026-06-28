<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function getAll()
    {
        return User::where('id_user', '!=', auth()->id())->get();
    }

    public function findById(int $id)
    {
        return User::findOrFail($id);
    }

    public function store(array $data)
    {
        $data['password'] = Hash::make($data['password']);

        return User::create($data);
    }

    public function update(int $id, array $data)
    {
        $user = $this->findById($id);
        unset($data['password']);
        $user->update($data);
        return $user;
    }

    public function delete(int $id)
    {
        $user = $this->findById($id);
        $user->delete();
    }
}
