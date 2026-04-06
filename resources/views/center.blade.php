@extends('layouts.app')

@section('content')
    <!-- Hero Start -->
    <div class="container-fluid bg-light py-5">
        <div class="container">
            <div class="row align-items-center">

                <!-- نص الهيرو + الآية -->
                <div class="col-md-6 mb-4 mb-md-0">
                    <h1 class="text-primary font-weight-bold mb-3">
                        معًا نحو تعليم أفضل
                    </h1>
                    <p class="text-secondary lead mb-3">
                        - مَن سلَكَ طريقًا يلتَمِسُ فيهِ علمًا
                        ، سَهَّلَ اللَّهُ لَهُ طريقًا إلى الجنَّةِ ، وإنَّ الملائِكَةَ لتَضعُ أجنحتَها لطالِبِ العلمِ رضًا
                        بما يصنعُ
                        وإنَّ العالم ليستغفِرُ لَهُ مَن في السَّمواتِ ومن في الأرضِ ، حتَّى الحيتانِ في الماءِ
                        ، وفضلَ العالمِ على العابدِ كفَضلِ القمرِ على سائرِ الكواكبِ
                        ، وإنَّ العُلَماءَ ورثةُ الأنبياءِ إنَّ الأنبياءَ لم يورِّثوا دينارًا ولا درهمًا إنَّما ورَّثوا
                        العلمَ فمَن أخذَهُ أخذَ بحظٍّ وافر
                    </p>

                    <!-- الآية -->
                    <p class="text-primary font-weight-bold h5">
                        وَقُل رَّبِّ زِدْنِي عِلْمًا
                        <span class="text-secondary d-block mt-2" style="font-size: 16px;">
                            (سورة طه، الآية 114)
                        </span>
                    </p>
                </div>

                <!-- الصورة -->
                <div class="col-md-6 text-center">
                    <img src="{{ asset('img/reg.jpeg') }}" class="img-fluid rounded shadow" alt="المركز">
                </div>

            </div>
        </div>
    </div>
    <!-- Hero End -->

    <!-- من نحن -->
    <div class="container py-5">
        <h2 class="text-primary font-weight-bold mb-4 text-center">
            من نحن
        </h2>
        <p class="text-secondary text-center w-75 mx-auto">
            نحن مركز زيد بن ثابت، نسعى إلى تقديم محتوى تعليمي مميز
            وتنظيم العملية التعليمية باستخدام أحدث الوسائل التقنية.
        </p>
    </div>

    <!-- إنجازات -->
    <div class="container-fluid py-5" style="background-color: #f8f9fa;">
        <div class="container">
            <h2 class="text-primary font-weight-bold mb-5 text-center">
                إنجازاتنا المميزة
            </h2>

            <div class="row text-center">

                <div class="col-md-4 mb-4">
                    <div class="p-4 bg-white rounded shadow-sm h-100 hover-shadow">
                        <div class="mb-3">
                            <i class="fas fa-book text-primary fa-3x"></i>
                        </div>
                        <h5 class="text-primary font-weight-bold mb-2">تحفيظ القرآن الكريم</h5>
                        <p class="text-secondary">
                            نختم القرآن لأجيال متعلمة، مع متابعة دقيقة لكل طالب لضمان الحفظ الصحيح والفهم العميق للمعاني.
                        </p>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="p-4 bg-white rounded shadow-sm h-100 hover-shadow">
                        <div class="mb-3">
                            <i class="fas fa-star text-warning fa-3x"></i>
                        </div>
                        <h5 class="text-primary font-weight-bold mb-2">تحفيز الطلاب</h5>
                        <p class="text-secondary">
                            برامج تحفيزية ومسابقات أسبوعية لتشجيع الطلاب على الاجتهاد والمثابرة.
                        </p>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="p-4 bg-white rounded shadow-sm h-100 hover-shadow">
                        <div class="mb-3">
                            <i class="fas fa-users text-success fa-3x"></i>
                        </div>
                        <h5 class="text-primary font-weight-bold mb-2">بيئة تعليمية داعمة</h5>
                        <p class="text-secondary">
                            بيئة تربوية هادئة ومشجعة مع معلمات متميزات.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <style>
        .hover-shadow:hover {
            transform: translateY(-5px);
            transition: all 0.3s ease;
        }
    </style>

    <!-- الإعلانات -->
    <div class="container-fluid bg-light py-5">
        <div class="container">
            <h2 class="text-primary font-weight-bold mb-4 text-center">
                الإعلانات
            </h2>

            <div class="row">
                @forelse($announcements as $announcement)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm rounded announcement-card">
                            <div class="card-body">

                                <!-- العنوان -->
                                <h5 class="card-title text-primary">
                                    {{ $announcement->title }}
                                </h5>

                                <!-- المحتوى -->
                                <p class="card-text text-secondary">
                                    {{ $announcement->content }}
                                </p>

                                <!-- الأزرار (مضافة فقط) -->
                                @auth
                                    @if (auth()->user()->role_id == 1)
                                        <div class="d-flex gap-2 mt-3 button-group">

                                            <!-- تعديل -->
                                            <a href="{{ route('admin.announcements.edit', $announcement) }}"
                                                class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i> تعديل
                                            </a>

                                            <!-- حذف -->
                                            <form action="{{ route('admin.announcements.destroy', $announcement) }}"
                                                method="POST" onsubmit="return confirm('هل أنت متأكد من حذف هذا الإعلان؟')">

                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash"></i> حذف
                                                </button>
                                            </form>

                                        </div>
                                    @endif
                                @endauth
                                <!-- نهاية الأزرار -->

                            </div>
                        </div>
                    </div>

                @empty
                    <div class="col-12">
                        <p class="text-center text-secondary">
                            لا توجد إعلانات حالياً.
                        </p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
