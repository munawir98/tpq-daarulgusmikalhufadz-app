<!DOCTYPE html>
<html class="dark" lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet" />
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#13ecb6",
                        "background-light": "#f6f8f8",
                        "background-dark": "#10221d",
                    },
                    fontFamily: {
                        "display": ["Plus Jakarta Sans"]
                    },
                    borderRadius: { "DEFAULT": "1rem", "lg": "2rem", "xl": "3rem", "full": "9999px" },
                },
            },
        }
    </script>
    <title>Panggilan Aktif - {{ $user->name }}</title>
    <style>
        body {
            height: 100dvh;
        }
    </style>
</head>

<body
    class="bg-background-light dark:bg-background-dark font-display antialiased text-slate-900 dark:text-slate-100 overflow-hidden">
    <div id="root" class="w-full h-screen bg-background-dark"></div>

    <script src="https://unpkg.com/@zegocloud/zego-uikit-prebuilt/zego-uikit-prebuilt.js"></script>
    <script>
        window.onload = function () {
            // Get credentials passed from controller
            const appID = {{ $appID }
        };
        const serverSecret = "{{ $serverSecret }}";
        const roomID = "{{ $roomID }}";
        const userID = "{{ $myUserId }}";
        const userName = "{{ $myName }}";

        // Generate a token (For production, this should ideally be generated on the backend,
        // but Web UI Kit allows testing token generation on frontend using serverSecret)
        const kitToken = ZegoUIKitPrebuilt.generateKitTokenForTest(appID, serverSecret, roomID, userID, userName);

        // Create instance object from token
        const zp = ZegoUIKitPrebuilt.create(kitToken);

        // Start the call
        zp.joinRoom({
            container: document.querySelector("#root"),
            sharedLinks: [{
                name: 'Personal link',
                url: window.location.origin + window.location.pathname + '?roomID=' + roomID,
            }],
            scenario: {
                mode: ZegoUIKitPrebuilt.OneONoneCall, // 1-on-1 calls
            },
            turnOnMicrophoneWhenJoining: true,
            turnOnCameraWhenJoining: false,
            showPreJoinView: false,
            showScreenSharingButton: false,
            showTextChat: false,
            showUserList: false,
            onLeaveRoom: () => {
                // Go back when call is ended
                window.history.back();
            }
        });
        };
    </script>
</body>

</html>
