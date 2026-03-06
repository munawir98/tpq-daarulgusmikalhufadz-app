<?php
$files = [
    'resources/views/chat/active_call.blade.php' => [
        "const appID = {{ \$appID }\n        };\n        const serverSecret" => "const appID = {{ \$appID }};\n        const serverSecret",
        "const appID = {{ \$appID }\r\n        };\r\n        const serverSecret" => "const appID = {{ \$appID }};\r\n        const serverSecret",
    ],
    'resources/views/ustadz/santri/index.blade.php' => [
        "' data:'" => "'data:'",
        "\n                            user->foto" => "user->foto",
        "\r\n                            user->foto" => "user->foto",
    ],
    'resources/views/ustadz/santri/confirm_delete.blade.php' => [
        "' data:'" => "'data:'",
        "\n                            user->foto" => "user->foto",
        "\r\n                            user->foto" => "user->foto",
    ]
];

foreach ($files as $file => $replacements) {
    if (!file_exists($file)) continue;
    $content = file_get_contents($file);
    foreach ($replacements as $search => $replace) {
        $content = str_replace($search, $replace, $content);
    }
    file_put_contents($file, $content);
    echo "Fixed $file\n";
}
echo "Done!\n";
