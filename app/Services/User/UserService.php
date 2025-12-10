<?php

namespace App\Services\User;

use App\Repositories\Contracts\UserRepositoryInterface;
use App\Http\Resources\UserResource;

class UserService
{
    protected $repo;

    public function __construct(UserRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function index()
    {
        return response()->json([
            'status' => true,
            'data' => UserResource::collection($this->repo->all())
        ]);
    }

    public function show($id)
    {
        return response()->json([
            'status' => true,
            'data' => new UserResource($this->repo->find($id))
        ]);
    }

    public function store($data)
    {
        $data['password'] = bcrypt($data['password']);

        $user = $this->repo->create($data);

        return response()->json([
            'status' => true,
            'message' => 'User berhasil ditambahkan',
            'data' => new UserResource($user)
        ]);
    }

    public function update($id, $data)
    {
        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }

        $user = $this->repo->update($id, $data);

        return response()->json([
            'status' => true,
            'message' => 'User berhasil diperbarui',
            'data' => new UserResource($user)
        ]);
    }

    public function destroy($id)
    {
        $this->repo->delete($id);

        return response()->json([
            'status' => true,
            'message' => 'User berhasil dihapus'
        ]);
    }
}
