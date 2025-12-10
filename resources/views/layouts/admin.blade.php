<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>@yield('title') | Dashboard Admin</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css">
</head>

<body class="hold-transition sidebar-mini">

    <div class="wrapper">

        <!-- NAVBAR -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a href="#" class="nav-link">Logout</a></li>
            </ul>
        </nav>

        <!-- SIDEBAR -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="#" class="brand-link text-center">
                <span class="brand-text">TPQ Admin Dashboard</span>
            </a>

            <div class="sidebar">
                <nav>
                    <ul class="nav nav-pills nav-sidebar flex-column">

                        <li class="nav-item">
                            <a href="/admin/dashboard" class="nav-link active">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dashboard Utama</p>
                            </a>
                        </li>

                    </ul>
                </nav>
            </div>
        </aside>

        <!-- CONTENT -->
        <div class="content-wrapper p-4">
            @yield('content')
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    @yield('scripts')

</body>

</html>
