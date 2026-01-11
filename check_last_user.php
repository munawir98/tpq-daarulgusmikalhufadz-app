<?php
$u = App\Models\User::latest()->first();
echo "Last User: ID=" . $u->id . " Name=" . $u->name . " Role=" . $u->role . " Email=" . $u->email . " Created=" . $u->created_at;
