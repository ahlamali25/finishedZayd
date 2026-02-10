<!-- resources/views/center.blade.php -->

@extends('layouts.app') <!-- إذا عندك layout جاهز -->

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
                   ، سَهَّلَ اللَّهُ لَهُ طريقًا إلى الجنَّةِ ، وإنَّ الملائِكَةَ لتَضعُ أجنحتَها لطالِبِ العلمِ رضًا بما يصنعُ
                    وإنَّ العالم ليستغفِرُ لَهُ مَن في السَّمواتِ ومن في الأرضِ ، حتَّى الحيتانِ في الماءِ
                     ، وفضلَ العالمِ على العابدِ كفَضلِ القمرِ على سائرِ الكواكبِ 
                    ، وإنَّ العُلَماءَ ورثةُ الأنبياءِ إنَّ الأنبياءَ لم يورِّثوا دينارًا ولا درهمًا إنَّما ورَّثوا العلمَ فمَن أخذَهُ أخذَ بحظٍّ وافر
                </p>

                <!-- الآية القرآنية -->
                <p class="text-primary font-weight-bold h5">
                    وَقُل رَّبِّ زِدْنِي عِلْمًا
                    <span class="text-secondary d-block mt-2" style="font-size: 16px;">
                        (سورة طه، الآية 114)
                    </span>
                </p>
            </div>

            <!-- صورة الهيرو (نفس صورة Navbar) -->
           <div class="col-md-6 text-center">
    <img src="{{ asset('img/reg.jpeg') }}" 
         class="img-fluid rounded shadow"
         alt="المركز">
</div>

        </div>
    </div>
</div>
<!-- Hero End -->

<!-- من نحن Start -->
<div class="container py-5">
    <h2 class="text-primary font-weight-bold mb-4 text-center">
        من نحن
    </h2>
    <p class="text-secondary text-center w-75 mx-auto">
        نحن مركز زيد بن ثابت، نسعى إلى تقديم محتوى تعليمي مميز
        وتنظيم العملية التعليمية باستخدام أحدث الوسائل التقنية.
    </p>
</div>
<!-- من نحن End -->

<!-- إنجازات المعهد Start -->
<div class="container-fluid py-5" style="background-color: #f8f9fa;">
    <div class="container">
        <h2 class="text-primary font-weight-bold mb-5 text-center">
            إنجازاتنا المميزة
        </h2>

        <div class="row text-center">

            <!-- إنجاز 1 -->
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

            <!-- إنجاز 2 -->
            <div class="col-md-4 mb-4">
                <div class="p-4 bg-white rounded shadow-sm h-100 hover-shadow">
                    <div class="mb-3">
                        <i class="fas fa-star text-warning fa-3x"></i>
                    </div>
                    <h5 class="text-primary font-weight-bold mb-2">تحفيز الطلاب</h5>
                    <p class="text-secondary">
                        برامج تحفيزية ومسابقات أسبوعية لتشجيع الطلاب على الاجتهاد والمثابرة في الحفظ والفهم.
                    </p>
                </div>
            </div>

            <!-- إنجاز 3 -->
            <div class="col-md-4 mb-4">
                <div class="p-4 bg-white rounded shadow-sm h-100 hover-shadow">
                    <div class="mb-3">
                        <i class="fas fa-users text-success fa-3x"></i>
                    </div>
                    <h5 class="text-primary font-weight-bold mb-2">بيئة تعليمية داعمة</h5>
                    <p class="text-secondary">
                        بيئة تربوية هادئة ومشجعة، مع معلمات متميزات يهتممن بتطوير مهارات الطلاب وحفظهم للقرآن.
                    </p>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- إنجازات المعهد End -->

<style>
/* تأثير بسيط عند المرور على الكارد */
.hover-shadow:hover {
    transform: translateY(-5px);
    transition: all 0.3s ease;
}
</style>


<!-- الإعلانات Start -->
<div class="container-fluid bg-light py-5">
    <div class="container">
        <!-- عنوان القسم -->
        <h2 class="text-primary font-weight-bold mb-4 text-center">
            الإعلانات
        </h2>

        <div class="row">
            @forelse($announcements as $announcement)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm rounded">
                        <div class="card-body">
                            <!-- عنوان الإعلان -->
                            <h5 class="card-title text-primary">{{ $announcement->title }}</h5>

                            <!-- محتوى الإعلان -->
                            <p class="card-text text-secondary">{{ $announcement->contact }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <p class="text-center text-secondary">لا توجد إعلانات حالياً.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
<!-- الإعلانات End -->

@endsection