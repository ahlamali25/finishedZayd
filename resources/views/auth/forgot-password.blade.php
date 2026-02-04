@extends('layouts.app')

@section('title', 'نسيت كلمة المرور')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">

            <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                <div class="row g-0">

                    <!-- الصورة -->
                    <div class="col-md-6 d-none d-md-block p-0">
                        <img src="{{ asset('img/child1.jpeg') }}"
                             class="img-fluid w-100 h-100"
                             style="object-fit: cover;">
                    </div>

                    <!-- الفورم -->
                    <div class="col-md-6 p-5" dir="rtl">
                        <h3 class="mb-4 text-center">إعادة تعيين كلمة المرور</h3>

                        @if (session('status'))
                            <div class="alert alert-success text-center">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf

                            <div class="mb-4">
                                <label class="form-label">البريد الإلكتروني</label>
                                <input type="email"
                                       name="email"
                                       class="form-control"
                                       placeholder="example@email.com"
                                       value="{{ old('email') }}"
                                       required>
                                @error('email')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-grid mb-3">
                                <button class="btn btn-primary py-2">
                                    إرسال رابط إعادة التعيين
                                </button>
                            </div>

                            <div class="text-center">
                                <a href="{{ route('login') }}"
                                   class="text-decoration-none fw-bold"
                                   style="color:#031f3d">
                                    العودة لتسجيل الدخول
                                </a>
                            </div>
                        </form>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
