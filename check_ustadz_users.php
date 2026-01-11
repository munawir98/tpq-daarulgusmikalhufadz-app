<?php
$users = App\Models\User::where('role', 'USTADZ')->get();
if ($users->isEmpty()) {
    echo "No Ustadz found.";
} else {
    foreach($users as $u) {
        echo "ID: " . $u->id . " | Name: " . $u->name . " | Email: " . $u->email . " | Created: " . $u->created_at . PHP_EOL;
    }
}
