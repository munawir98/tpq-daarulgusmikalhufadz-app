<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\GroupMember;

/*
|--------------------------------------------------------------------------
| GROUP CHAT CHANNEL
|--------------------------------------------------------------------------
|
| Mengizinkan hanya user yang merupakan anggota group
| untuk subscribe ke channel realtime group.{groupId}.
|
*/

Broadcast::channel('group.{groupId}', function ($user, $groupId) {

    // Cek membership dari cache (lebih cepat dari DB)
    $isMember = cache()->remember(
        "group_member_{$groupId}_{$user->id}",
        10, // 10 detik
        fn() => GroupMember::where('group_id', $groupId)
                ->where('user_id', $user->id)
                ->exists()
    );

    if (! $isMember) {
        return false;
    }

    // Return detail user ke client realtime
    return [
        'id'    => $user->id,
        'name'  => $user->name,
        'foto'  => $user->foto ? asset('storage/' . $user->foto) : null,
    ];
});


/*
|--------------------------------------------------------------------------
| PRIVATE CHAT CHANNEL
|--------------------------------------------------------------------------
|
| private-chat.{receiverId}
| Hanya penerima pesan (receiver) yang boleh mendengarkan channel ini.
|
*/

Broadcast::channel('private-chat.{receiverId}', function ($user, $receiverId) {

    // hanya receiver yang boleh join channel
    return (int) $user->id === (int) $receiverId;
});
