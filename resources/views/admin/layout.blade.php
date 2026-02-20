<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>لوحة الإدارة</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet" />

    <style>
        body {
            background: #f5f7fb;
        }

        /* ===== Sidebar ===== */
        .sidebar {
            width: 260px;
            min-height: 100vh;
            background: #4da1b4;
            color: #fff;
            box-sizing: border-box;
        }

        .sidebar h5 {
            font-weight: bold;
        }

        .sidebar-link,
        .sidebar-logout {
            color: #edf2f4;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 15px;
            border-radius: 12px;
            margin-bottom: 6px;
            font-size: 14px;
            white-space: nowrap;
            background: none;
            border: none;
            width: 100%;
            text-align: start;
            cursor: pointer;
        }

        .sidebar-link:hover,
        .sidebar-logout:hover,
        .sidebar-link.active {
            background: #64dada;
            color: #000;
        }

        .sidebar form {
            margin: 0;
        }


        .card-box {
            border-radius: 18px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, .05);
        }

        .banner {
            background: #64dada;
            color: #000;
            border-radius: 18px;
        }
    </style>
</head>

<body>

    <div class="d-flex">
        <!-- Sidebar -->
        <aside class="sidebar p-3">
            <h5 class="mb-4">
                <i class="bi bi-shield-lock"></i> لوحة الإدارة
            </h5>

            <!-- Dashboard -->
            <a href="{{ route('admin.dashboard') }}"
                class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i>
                لوحة التحكم
            </a>



            <!-- Groups -->
            <a href="{{ route('admin.class-groups.index') }}"
                class="sidebar-link {{ request()->routeIs('admin.class-groups.*') ? 'active' : '' }}">
                <i class="bi bi-diagram-3"></i>
                الحلقات
            </a>

            <!-- Users -->
            <a href="{{ route('admin.users.index') }}"
                class="sidebar-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <i class="bi bi-people"></i>
                المستخدمون
            </a>

            <!-- home -->
            <a href="{{ route('home') }}" class="sidebar-link {{ request()->routeIs('home') ? 'active' : '' }}">
                <i class="bi bi-house-door"></i>
                الرئيسية
            </a>

            <!-- Logout -->
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="sidebar-logout">
                    <i class="bi bi-box-arrow-right"></i>
                    تسجيل الخروج
                </button>
            </form>
        </aside>


        <!-- Content -->
        <div class="flex-grow-1 p-4">
            @yield('content')
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
