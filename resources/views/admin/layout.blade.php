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
        body{background:#f5f7fb;}
    .sidebar{
    width:260px;           /* زودنا العرض */
    min-height:100vh;
    background:#4da1b4;
    color:#fff;
}

.sidebar a{
    color:#edf2f4;
    text-decoration:none;
    display:flex;          /* مهم */
    align-items:center;    /* توسيط عمودي */
    gap:8px;               /* مسافة بين الأيقونة والنص */
    padding:10px 15px;
    border-radius:12px;
    margin-bottom:6px;
    font-size:14px;
    white-space:nowrap;    /* يمنع النزول لسطر جديد */
}

        .sidebar a.active,
        .sidebar a:hover{
            background:#64dada;
            color:#000;
        }
        .card-box{
            border-radius:18px;
            box-shadow:0 10px 25px rgba(0,0,0,.05);
        }
        .banner{
            background:#64dada;
            color:#000;
            border-radius:18px;
        }
    </style>
</head>

<body>

<div class="d-flex">

    <!-- Sidebar -->
    <div class="sidebar p-3">
        <h5 class="mb-4">
            <i class="bi bi-shield-lock"></i> لوحة الإدارة
        </h5>

        <a class="active">
            <i class="bi bi-speedometer2 me-2"></i> الرئيسية
        </a>

    

        <a href="#">
            <i class="bi bi-diagram-3 me-2"></i> الحلقات
        </a>

<a href="{{ route('admin.users.index') }}">
    <i class="bi bi-people me-2"></i> المستخدمون
</a>

        <a href="{{ route('logout') }}">
            <i class="bi bi-box-arrow-right me-2"></i> تسجيل الخروج
        </a>
    </div>

    <!-- Content -->
    <div class="flex-grow-1 p-4">
        @yield('content')
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
