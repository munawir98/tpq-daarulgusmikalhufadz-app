<?php

namespace App\Repositories\Eloquent;

use App\Models\Group;
use App\Models\GroupMember;
use App\Repositories\Contracts\GroupRepositoryInterface;

class GroupRepository implements GroupRepositoryInterface
{
    public function all()
    {
        return Group::with('members')->get();
    }

    public function find($id)
    {
        return Group::with('members')->findOrFail($id);
    }

    public function create(array $data)
    {
        // Buat group baru
        $group = Group::create([
            'name'       => $data['name'],
            'created_by' => $data['created_by'],
        ]);

        // Tambahkan member awal bila ada
        if (!empty($data['members']) && is_array($data['members'])) {
            foreach ($data['members'] as $userId) {
                GroupMember::create([
                    'group_id' => $group->id,
                    'user_id'  => $userId
                ]);
            }
        }

        return $group;
    }

    public function addMember($groupId, $userId)
    {
        return GroupMember::create([
            'group_id' => $groupId,
            'user_id'  => $userId
        ]);
    }

    public function members($groupId)
    {
        return GroupMember::where('group_id', $groupId)
            ->with('user')
            ->get();
    }

    public function removeMember($groupId, $userId)
    {
        return GroupMember::where('group_id', $groupId)
            ->where('user_id', $userId)
            ->delete();
    }

    public function rename($groupId, $name)
    {
        return Group::where('id', $groupId)
            ->update(['name' => $name]);
    }

    public function delete($groupId)
    {
        return Group::destroy($groupId);
    }
}
