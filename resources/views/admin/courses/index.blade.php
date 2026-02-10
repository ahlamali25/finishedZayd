@extends('layouts.app')

@section('title', 'الدورات')

@section('content')

    <!-- Courses Start -->
    <div class="container py-5">

        <!-- العنوان + زر التسجيل -->
        <div class="d-flex justify-content-between align-items-center mb-5">


            <button class="btn btn-primary" data-toggle="modal" data-target="#registerModal">
                سجل في إحدى الدورات
            </button>
        </div>

        <!-- عرض الكورسات -->
        <div class="row">

            @forelse($courses as $course)
                <div class="col-lg-4 col-md-6 pb-4 d-flex">
                    <div class="bg-light shadow-sm border-top rounded p-4 h-100 w-100 text-right">
                        <h4 class="mb-3 text-primary">{{ $course->name }}</h4>
                        <p class="m-0">
                            {{ $course->description ?? 'لا يوجد وصف للدورة' }}
                        </p>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center">
                    <p>لا توجد دورات حالياً</p>
                </div>
            @endforelse

        </div>
    </div>
    <!-- Courses End -->


    <!-- Modal التسجيل -->
    <div class="modal fade" id="registerModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 overflow-hidden">

                <div class="row no-gutters d-flex align-items-stretch">

                    <!-- الصورة -->
                    <div class="col-md-6 d-none d-md-block p-0">
                        <img src="{{ asset('img/enroll.jpeg') }}" class="img-fluid w-100 h-100" style="object-fit: cover;">
                    </div>

                    <!-- الفورم -->
                    <div class="col-md-6 p-5 d-flex flex-column justify-content-center" dir="rtl">

                        <h4 class="mb-4 text-center text-secondary font-weight-bold">
                            التسجيل في دورة
                        </h4>
                    @if(Auth::check())
                            <form method="POST" action="{{ route('enrollments.store') }}">
                                @csrf

                                <div class="form-group">
                                    <label>اختر الدورة</label>
                                    <select class="form-control" name="course_id" required>
                                        @foreach ($courses as $index => $course)
                                            <option value="{{ $course->id }}" {{ $index === 0 ? 'selected' : '' }}>
                                                {{ $course->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-primary btn-block py-2">
                                    تسجيل
                                </button>

                            </form>
                        @else
                        <a href="{{ route('login') }}" class="btn btn-primary btn-block"> سجل الدخول للانضمام</a>
                        @endif

                        </div>
       

                    </div>

                </div>

            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const token = localStorage.getItem('token');
            const authForm = document.getElementById('authForm');
            const noAuthForm = document.getElementById('noAuthForm');

            if (token) {
                authForm.style.display = 'block';
                noAuthForm.style.display = 'none';
            } else {
                authForm.style.display = 'none';
                noAuthForm.style.display = 'block';
            }
        });
    </script>
@endpush