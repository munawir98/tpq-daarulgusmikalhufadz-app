<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserRepositoryInterface
{
    public function all()
    {
        return User::orderByDesc('id')->get();
    }

    public function find($id)
    {
        return User::findOrFail($id);
    }

    public function findByRole($role)
    {
        return User::where('role', $role)->get();
    }

    public function create($data)
    {
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        return User::create($data);
    }

    public function update($id, $data)
    {
        $user = User::findOrFail($id);

        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        $user->update($data);
        return $user;
    }

    public function delete($id)
    {
        return User::destroy($id);
    }
}
