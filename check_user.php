<?php
$users = App\Models\User::where('name', 'like', '%Munawir%')->get();
foreach($users as $u) {
    echo "ID: " . $u->id . " | Name: " . $u->name . " | Role: " . $u->role . PHP_EOL;
}
