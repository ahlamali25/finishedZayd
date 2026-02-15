@extends('layouts.app')

@section('content')
    <!-- Header Start -->
    <div class="container-fluid bg-primary px-0 px-md-5 mb-5">
        <div class="row align-items-center px-3">
            <div class="col-lg-6 text-center text-lg-left">
                <h4 class="text-white mb-4 mt-5 mt-lg-0">مركز زيد بن ثابت</h4>
                <h1 class="display-3 font-weight-bold text-white">
                    {وقُل رَّبِّ زِدْنِي عِلْمًا}
                </h1>
                <p class="text-white mb-4">
                    يسعى مركزنا لتحفيظ القرآن الكريم وتعليم العلوم الشرعية واللغة العربية حيث نسعى لتأمين التعلم للجميع سواء
                    كانوا صغارا أو كبارا
                    راجين من الله التوفيق والسداد في مسعانا هذا لخدمة كتاب الله تعالى وتعليم الناس الخير
                </p>
                <a href="{{ route('register') }}" class="btn btn-secondary mt-1 py-3 px-5">انضم إلى مركزنا</a>
            </div>
            <div class="col-lg-6 text-center text-lg-right">
                <img class="img-fluid mt-5" src="{{ asset('img/header.png') }}" alt="header" />
            </div>
        </div>
    </div>
    <!-- Header End -->

    <!-- Institute Courses Offers -->

    <div class="container-fluid pt-5">
        <div class="container pb-3">

            <div id="coursesCarousel" class="carousel slide" data-ride="carousel">

                <!-- Indicators -->
                <ol class="carousel-indicators">
                    @foreach ($courses->chunk(6) as $index => $chunk)
                        <li data-target="#coursesCarousel" data-slide-to="{{ $index }}"
                            class="{{ $index == 0 ? 'active' : '' }}"></li>
                    @endforeach
                </ol>

                <div class="carousel-inner">

                    @foreach ($courses->chunk(6) as $index => $chunk)
                        <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                            <div class="row">

                                @foreach ($chunk as $course)
                                    <div class="col-lg-4 col-md-6 pb-4 d-flex">
                                        <div class="bg-light shadow-sm border-top rounded p-4 h-100 w-100 text-right">
                                            <h4 class="mb-3">{{ $course->name }}</h4>
                                            <p class="m-0">{{ $course->description }}</p>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    @endforeach

                </div>
            </div>

        </div>
    </div>

    <!--  Institute Courses Offers End-->
    
    <!-- About Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-5">
                    <img class="img-fluid rounded mb-5 mb-lg-0" src="img/logo.png" alt="" />
                </div>
                <div class="col-lg-7">
                    <p class="section-title pr-5">
                        <span class="pr-2 text-primary">تعرّف علينا</span>
                    <h1 class="mb-4">نؤمن أن العلم الشرعي لا يُلقَّن فقط، بل يُغرس في القلوب غرسًا</h1>
                    <p class="mb-3">
                        لذلك نسعى في منصة زيد بن ثابت إلى تعليم العلوم الشرعية بأسلوب يسيرٍ ومحبّبٍ للنفس،
                        يربط المتعلم بكتاب الله وسنة نبيه ﷺ، وينمّي فيه الفهم والتطبيق والعمل.
                    </p>
                    <p class="text-muted fst-italic" style="font-size: 1.1rem; line-height: 1.8;">
                        "خيرُكم من تعلَّم القرآنَ وعلَّمَهُ" <br>
                        <span style="font-size: 0.95rem;">— حديث نبوي شريف</span>
                    </p>
                    <div class="row pt-2 pb-4">
                        <div class="col-6 col-md-4">
                            <img class="img-fluid rounded" src="{{ asset('img/child.jpeg') }}" alt="child" />
                        </div>
                        <div class="col-6 col-md-8">
                            <ul class="list-inline m-0">
                                <li class="py-2 border-top border-bottom">
                                    <i class="fa fa-check text-primary mr-3"></i>نغرس حبَّ القرآن في قلوب الناشئة
                                </li>
                                <li class="py-2 border-bottom">
                                    <i class="fa fa-check text-primary mr-3"></i>نُنمِّي الفهم والعمل معًا في رحاب العلم
                                </li>
                                <li class="py-2 border-bottom">
                                    <i class="fa fa-check text-primary mr-3"></i>نربط المتعلم بكتاب الله وسنّة نبيه ﷺ
                                </li>
                            </ul>
                        </div>
                    </div>
                    <a href="{{ route('center.page') }}" class="btn btn-primary mt-2 py-2 px-4"> المزيد</a>
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->

      {{-- نافذة تنبيه العمر --}}
@if (session('error'))
<div class="modal fade show" id="ageModal" style="display:block;" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center">

            <div class="modal-header">
                <h5 class="modal-title text-danger">تنبيه</h5>
                <button type="button" class="btn-close" onclick="closeModal()"></button>
            </div>

            <div class="modal-body">
                <p>{{ session('error') }}</p>
                <p class="text-muted">يرجى اختيار الحلقة المناسبة لعُمرك</p>
            </div>

            <div class="modal-footer">
                <button class="btn btn-primary" onclick="closeModal()">حسنًا</button>
            </div>

        </div>
    </div>
</div>

<script>
function closeModal() {
    document.getElementById('ageModal').style.display = 'none';
}
</script>
@endif

    <!-- Class Start -->
    <div class="container-fluid pt-5">
        <div class="container">

            <div class="text-center pb-2">
                <p class="section-title px-5">
                    <span class="px-2">حلقات مركزنا</span>
                </p>
                <h1 class="mb-4">مراحل تعليمية تنمو بنور القرآن</h1>
            </div>

            <div class="row">

                @foreach ($class_types as $class)
                    @php
                        // تحديد الصورة
                        if (!empty($class->image)) {
                            // صورة مرفوعة من المعلم
                            $image = 'img/' . $class->image;
                        } else {
                            // صور افتراضية حسب اسم الحلقة
                            switch ($class->name) {
                                case 'جيل الفرقان':
                                    $image = 'img/furqan.jpeg';
                                    break;

                                case 'زهرات الإيمان':
                                    $image = 'img/flower.jpeg';
                                    break;

                                case 'براعم الجنة':
                                    $image = 'img/buds.png';
                                    break;

                                case  'روّاد الخير':
                                    $image = 'img/good.jpeg';
                                    break;

                                case 'حملة القرآن':
                                    $image = 'img/quranCampaign.jpeg';
                                    break;    

                                default:
                                    // صورة افتراضية عامة
                                    $image = 'img/default.jpeg';
                            }
                        }
                    @endphp

                    <div class="col-lg-4 mb-5">
                        <div class="card border-0 bg-light shadow-sm pb-2">

                            <!-- الصورة -->
                            <img class="card-img-top mb-2" src="{{ asset($image) }}" alt="{{ $class->name }}"
                                style="width: 100%; height: 220px; object-fit: cover;">

                            <div class="card-body text-center">
                                <h4 class="card-title">{{ $class->name }}</h4>
                                <p class="card-text">{{ $class->description }}</p>
                            </div>

                            <div class="card-footer bg-transparent py-4 px-5">

                                <div class="row border-bottom">
                                    <div class="col-6 py-1 text-right border-right">
                                        <strong>العمر</strong>
                                    </div>
                                    <div class="col-6 py-1">
                                        {{ $class->age_from }} -
                                        {{ $class->age_to ?? 'فما فوق' }}
                                    </div>
                                </div>

                                <div class="row border-bottom">
                                    <div class="col-6 py-1 text-right border-right">
                                        <strong>وقت الحصة</strong>
                                    </div>
                                    <div class="col-6 py-1">
                                        {{ date('H:i', strtotime($class->start_time)) }} -
                                        {{ date('H:i', strtotime($class->end_time)) }}
                                    </div>
                                </div>

                            </div>

                              @auth
                                <form action="{{ route('join.class', $class->id) }}" method="POST"
                                    style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-primary px-4 mx-auto mb-4">
                                        انضم الآن
                                    </button>
                                </form>
                                {{-- <button class="btn btn-info mx-2" onclick="showGroups({{ $class->id }})"> --}}
                                    {{-- <i class="fa fa-eye"></i>
                                </button> --}}
                            @else
                                <a href="{{ route('login') }}" class="btn btn-primary px-4 mx-auto mb-4">
                                    انضم الآن
                                </a>
                            @endauth

                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
    <!-- Class End -->





    <!-- Team Start -->
    <div class="container-fluid pt-5">
        <div class="container">
            <div class="text-center pb-2">
                <p class="section-title px-5">
                    <span class="px-2">المعلمات</span>
                </p>
                <h1 class="mb-4">
                    {يَرْفَعِ اللَّهُ الَّذِينَ آمَنُوا مِنْكُمْ وَالَّذِينَ أُوتُوا الْعِلْمَ دَرَجَاتٍ}
                </h1>
            </div>

            <div id="teachersCarousel" class="carousel slide" data-ride="carousel">

                <!-- النقاط الدائرية -->
                <ol class="carousel-indicators">
                    @foreach ($teachers->chunk(4) as $index => $chunk)
                        <li data-target="#teachersCarousel" data-slide-to="{{ $index }}"
                            class="{{ $index == 0 ? 'active' : '' }}">
                        </li>
                    @endforeach
                </ol>

                <div class="carousel-inner">

                    @foreach ($teachers->chunk(4) as $index => $chunk)
                        <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                            <div class="row">

                                @foreach ($chunk as $teacher)
                                    <div class="col-md-6 col-lg-3 text-center team mb-5">

                                       <div class="position-relative overflow-hidden mb-4" style="border-radius: 100%">
                                        <img class="img-fluid w-100" src="{{ asset('img/teacher.jpeg') }}"
                                            alt="teacher">
                                        <div class="team-social d-flex align-items-center justify-content-center w-100 h-100 position-absolute">
                                            @if($teacher->social && $teacher->social->facebook_link)
                                            <a class="btn btn-outline-light text-center mr-2 px-0"
                                                style="width:38px;height:38px"
                                                href="{{ $teacher->social->facebook_link }}" target="_blank">
                                                <i class="fab fa-facebook-f"></i>
                                            </a>
                                            @endif

                                            @if($teacher->social && $teacher->social->instagram_link)
                                            <a class="btn btn-outline-light text-center px-0"
                                                style="width:38px;height:38px"
                                                href="{{ $teacher->social->instagram_link }}" target="_blank">
                                                <i class="fab fa-instagram"></i>
                                            </a>
                                            @endif
                                        </div>
                                    </div>

                                        <h4>الآنسة {{ $teacher->user->name }}</h4>
                                        <i>{{ $teacher->specialization }}</i>

                                    </div>
                                @endforeach

                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>

    @include('partials.footer')
@endsection

<script>
    function showGroups(classTypeId) {
        fetch('/class-groups-count/' + classTypeId)
            .then(response => response.json())
            .then(data => {
                alert('عدد الحلقات الفرعية: ' + data.count);
            })
            .catch(error => {
                console.error('Error:', error);
                alert('حدث خطأ في جلب البيانات');
            });
    }
</script>
