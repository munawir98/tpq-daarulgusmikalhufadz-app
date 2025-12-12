<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;

class GroupController extends Controller
{
    /**
     * ===========================================================
     * AUTO-SUGGEST MENTION
     * ===========================================================
     * Flutter memanggil:
     * GET /group/{group}/mention/search?query=ust
     * ===========================================================
     */
    public function searchMention(Request $request, $groupId)
    {
        $query = strtolower($request->query('query', ''));

        // Ambil semua member group
        $group = Group::with('members.profile')->findOrFail($groupId);

        // Jika user mengetik "@all"
        if ($query === 'all') {
            return response()->json([
                "status" => true,
                "data"   => [
                    [
                        "id"       => null,
                        "username" => "all",
                        "name"     => "Semua Anggota",
                        "avatar"   => null,
                        "type"     => "all",
                    ]
                ]
            ]);
        }


        /**
         * ===========================================================
         * AUTO-SUGGEST ROLE (ustadz, admin, dsb)
         * Flutter ketik: @ustadz → tampilkan semua ustadz
         * ===========================================================
         */
        $roleMatches = User::where('role', 'LIKE', "%$query%")
            ->get(['id', 'name', 'username', 'role']);

        $roleResults = $roleMatches->map(function ($user) {
            return [
                "id"       => $user->id,
                "username" => $user->username,
                "name"     => $user->name,
                "avatar"   => optional($user->profile)->photo_url,
                "role"     => $user->role,
                "type"     => "role"
            ];
        });


        /**
         * ===========================================================
         * AUTO-SUGGEST USERNAME / NAME
         * ===========================================================
         */
        $userResults = $group->members->filter(function ($user) use ($query) {
            return str_contains(strtolower($user->username), $query)
                || str_contains(strtolower($user->name), $query);
        })->map(function ($user) {
            return [
                "id"       => $user->id,
                "username" => $user->username,
                "name"     => $user->name,
                "avatar"   => optional($user->profile)->photo_url,
                "type"     => "user"
            ];
        });


        /**
         * ===========================================================
         * DETEKSI MENTION BY ID (@id:17)
         * ===========================================================
         */
        if (str_starts_with($query, 'id:')) {

            $userId = str_replace('id:', '', $query);

            $user = $group->members->firstWhere('id', $userId);

            if ($user) {
                return response()->json([
                    "status" => true,
                    "data"   => [[
                        "id"       => $user->id,
                        "username" => $user->username,
                        "name"     => $user->name,
                        "avatar"   => optional($user->profile)->photo_url,
                        "type"     => "id"
                    ]]
                ]);
            }
        }


        /**
         * ===========================================================
         * GABUNG SEMUA HASIL
         * ===========================================================
         */
        $merged = $roleResults
            ->merge($userResults)
            ->unique('id')
            ->values();

        return response()->json([
            "status" => true,
            "data"   => $merged
        ]);
    }




    /**
     * ===========================================================
     * AMBIL DETAIL GROUP + MEMBER
     * ===========================================================
     */
    public function detail($groupId)
    {
        $group = Group::with('members.profile')->findOrFail($groupId);
        return ApiResponse::success($group);
    }


    /**
     * ===========================================================
     * LIST GROUP USER LOGIN
     * ===========================================================
     */
    public function myGroups()
    {
        $groups = auth()->user()->groups()->get();
        return ApiResponse::success($groups);
    }


    /**
     * ===========================================================
     * LIST ROLE (Ustadz / Admin / Pengajar / Santri)
     * ===========================================================
     */
    public function roleList()
    {
        $roles = User::select('role')->distinct()->pluck('role');

        return ApiResponse::success($roles);
    }
}
