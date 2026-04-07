<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>لوحة الطالب</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet" />

    <style>
        body{background:#f5f7fb;}
        .sidebar{
            width:230px;
            min-height:100vh;
            background:#0b2c73;
            color:#fff;
        }
        .sidebar a{
            color:#cfd8ff;
            text-decoration:none;
            display:block;
            padding:10px 15px;
            border-radius:12px;
            margin-bottom:6px;
            font-size:14px;
        }
        .sidebar a.active,
        .sidebar a:hover{
            background:#143c9a;
            color:#fff;
        }
        .card-box{
            border-radius:18px;
            box-shadow:0 10px 25px rgba(0,0,0,.05);
        }
        .banner{
            background:#123b9a;
            color:#fff;
            border-radius:18px;
        }

        /* Teacher CTA */
.teacher-cta{
    background:#eef2ff;
    border-radius:18px;
    padding:18px 22px;
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.teacher-cta h6{
    font-weight:600;
    margin:0;
    color:#1c2d7a;
}

.teacher-cta small{
    color:#6b7280;
}
    </style>
</head>

<body>
<div class="d-flex">

    <!-- Sidebar -->
    <div class="sidebar p-3">
        <h5 class="mb-4"><i class="bi bi-mortarboard"></i> لوحة الطالب</h5>

        <a class="active" href="{{ route('dashboard') }}"><i class="bi bi-speedometer2 me-2"></i>لوحة التحكم</a>
        <a href="{{ route('student.courses') }}"><i class="bi bi-book me-2"></i> كورساتي</a>
        <a href="{{ route('home') }}" ><i class="bi bi-house-door me-2"></i> الرئيسية</a>
        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
    <i class="bi bi-box-arrow-right me-2"></i> تسجيل الخروج
</a>

<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>

    </div>

    <!-- Main Content -->
    <div class="flex-grow-1 p-4">

        <!-- Banner -->
        <div class="banner p-4 mb-4 d-flex justify-content-between align-items-center">
            <div>
                <p class="mb-1">التاريخ: {{ now()->format('Y-m-d') }}</p>
                <h4>أهلاً بعودتك، {{ auth()->user()->name }} 👋</h4>
                <small>عدد الدورات الملتحقة بها: {{ $courses->count() }}</small>
            </div>
            <img src="{{ asset('img/studentD.jpeg') }}" alt="Student Banner"
                 width="90" class="rounded-circle bg-white p-2" />
        </div>

    <!-- Teacher CTA -->
    <div class="teacher-cta mb-4">
        <div>
            <h6>هل ترغب بأن تصبح معلماً؟</h6>
            <small>انضم لفريق المعلمين وابدأ رحلتك التعليمية معنا.</small>
        </div>

        <a href="{{ route('teacher.apply.form') }}"
           class="btn btn-primary btn-modern">
           تقديم الطلب
        </a>
    </div>

        <!-- Courses -->
    
<div class="d-flex justify-content-between mb-2">
    <h5>كورساتي المسجلة</h5>


</div>

<div class="row g-3">
    @forelse($courses->take(2) as $course) <!-- عرض أول دورتين فقط -->
        <div class="col-md-6">
            <div class="card card-box p-3">
                <h6>{{ $course->name }}</h6>
                <p class="text-muted small mb-2">{{ $course->description }}</p>
                <a href="{{ route('lessons.learn.course', $course->id) }}"
   class="btn btn-primary btn-sm">
   الدخول للكورس
</a>
            </div>
        </div>
    @empty
        <p class="text-muted">لا توجد دورات بعد.</p>
    @endforelse
</div>


        <!-- Classes -->
        <div class="card shadow-sm mt-4 mb-5">
            <div class="card-header text-right">
                <h5 class="mb-0">الحلقة </h5>
            </div>
            <div class="card-body">
                @if($classes->isEmpty())
                    <p class="text-right">لا توجد حلقات بعد.</p>
                @else
                    <ul class="list-group list-group-flush">
                        @foreach($classes as $class)
                            @php
                                $type = $class->classType;
                                switch ($type->name) {
                                    case 'حملة القرآن': $image = 'img/quranCampaign.jpeg'; break;
                                    case 'براعم الجنة': $image = 'img/buds.png'; break;
                                    case 'زهرات الإيمان': $image = 'img/flower.jpeg'; break;
                                    case 'جيل الفرقان': $image = 'img/furqan.jpeg'; break;
                                    case 'روّاد الخير': $image = 'img/good.jpeg'; break;
                                    default: $image = 'img/default.jpeg';
                                }
                            @endphp

                            <li class="list-group-item d-flex align-items-center">
                                <div class="d-flex align-items-center" style="width: 40%;">
                                    <img src="{{ asset($image) }}" alt="{{ $type->name }}"
                                         class="rounded-circle me-3" style="width: 60px; height: 60px; object-fit: cover;">
                                    <strong>{{ $type->name }} {{ $class->group_number }}</strong>
                                </div>

                                <div class="text-muted text-center" style="width: 30%;">
                                    {{ date('H:i', strtotime($type->start_time)) }}
                                    -
                                    {{ date('H:i', strtotime($type->end_time)) }}
                                </div>

                                <div class="text-end" style="width: 30%;">
                                    <a href="{{ route('class_groups.courses', $class->id) }}" class="btn btn-outline-primary btn-sm">
                                        دخول الحلقة
                                    </a>
                                </div>
                                              <div>
                                @foreach(auth()->user()->classGroup as $group)
                                <!-- زر الانسحاب -->
                                <form action="{{ route('class-group.leave', $group->id) }}" method="POST"
                                    onsubmit="return confirm('هل أنت متأكد من رغبتك في الانسحاب من هذه الحلقة؟')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-primary btn-sm ">
                                        <i class="bi bi-box-arrow-right"></i> مغادرة الحلقة
                                    </button>
                                </form>
                                @endforeach
                            </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>

    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
