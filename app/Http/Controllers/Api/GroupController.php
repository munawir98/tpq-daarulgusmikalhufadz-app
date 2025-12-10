<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\GroupRequest;
use App\Http\Resources\GroupResource;
use App\Models\Group;
use App\Helpers\ApiResponse;

class GroupController extends Controller
{
    // ==========================================================
    // LIST GROUP USER
    // ==========================================================
    public function index()
    {
        $userId = auth()->id();

        $groups = Group::with(['members.user', 'latestMessage.sender'])
            ->whereHas('members', fn($q) => $q->where('user_id', $userId))
            ->orderByDesc(
                Group::select('created_at')
                ->from('group_messages')
                ->whereColumn('group_id', 'groups.id')
                ->latest()
                ->limit(1)
            )
            ->get();

        return ApiResponse::success(GroupResource::collection($groups));
    }

    // ==========================================================
    // CREATE GROUP
    // ==========================================================
    public function store(GroupRequest $request)
    {
        $group = Group::create([
            'name'        => $request->name,
            'description' => $request->description,
            'owner_id'    => auth()->id(),
        ]);

        // Tambahkan anggota grup
        $group->members()->sync($request->members);

        return ApiResponse::success(
            new GroupResource($group),
            "Grup berhasil dibuat"
        );
    }

    // ==========================================================
    // ADD MEMBER
    // ==========================================================
    public function addMember($id, GroupRequest $request)
    {
        $group = Group::findOrFail($id);

        $group->members()->syncWithoutDetaching($request->members);

        return ApiResponse::success(
            new GroupResource($group->load('members.user')),
            "Anggota berhasil ditambahkan"
        );
    }

    // ==========================================================
    // MEMBERS LIST
    // ==========================================================
    public function members($id)
    {
        $group = Group::with('members.user')->findOrFail($id);

        return ApiResponse::success(
            new GroupResource($group),
            "Daftar anggota grup ditemukan"
        );
    }

    // ==========================================================
    // REMOVE MEMBER
    // ==========================================================
    public function removeMember($groupId, $userId)
    {
        $group = Group::findOrFail($groupId);

        $group->members()->detach($userId);

        return ApiResponse::success(null, "Anggota berhasil dihapus");
    }

    // ==========================================================
    // UPDATE GROUP NAME
    // ==========================================================
    public function rename(GroupRequest $request, $id)
    {
        $group = Group::findOrFail($id);

        $group->update(['name' => $request->name]);

        return ApiResponse::success(new GroupResource($group), "Nama grup diperbarui");
    }

    // ==========================================================
    // DELETE GROUP
    // ==========================================================
    public function destroy($id)
    {
        $group = Group::findOrFail($id);
        $group->delete();
        $group->members()->delete();

        return ApiResponse::success(null, "Grup berhasil dihapus");
    }

    // ==========================================================
    // TYPING INDICATOR
    // ==========================================================
    public function typing(GroupRequest $request)
    {
        cache()->put(
            "group_typing_" . $request->group_id,
            auth()->user()->name,
            3 // expired in 3 sec
        );

        return ApiResponse::success(null, "Typing updated");
    }

    public function checkTyping($id)
    {
        return ApiResponse::success([
            "typing" => cache()->get("group_typing_" . $id)
        ]);
    }
}
