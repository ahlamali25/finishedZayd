@extends('layouts.app')

@section('title', 'إعادة تعيين كلمة المرور')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">

            <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                <div class="row g-0">

                    <!-- العمود الأيسر (الصورة) -->
                    <div class="col-md-6 d-none d-md-block p-0">
                        <img src="{{ asset('img/set.jpeg') }}"
                             alt="reset password image"
                             class="img-fluid w-100 h-100"
                             style="object-fit: cover;">
                    </div>

                    <!-- العمود الأيمن (الفورم) -->
                    <div class="col-md-6 p-5" dir="rtl">
                        <h3 class="mb-4 text-center">إعادة تعيين كلمة المرور</h3>

                        <form method="POST" action="{{ route('password.store') }}">
                            @csrf

                            <!-- Token -->
                            <input type="hidden" name="token" value="{{ request()->route('token') }}">

                            <!-- Email -->
                            <div class="mb-3">
                                <label class="form-label">البريد الإلكتروني</label>
                                <input type="email"
                                       name="email"
                                       class="form-control"
                                       value="{{ old('email', request('email')) }}"
                                       required autofocus>

                                @error('email')
                                    <div class="text-danger mt-1 small">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="mb-3">
                                <label class="form-label">كلمة المرور الجديدة</label>
                                <input type="password"
                                       name="password"
                                       class="form-control"
                                       required>

                                @error('password')
                                    <div class="text-danger mt-1 small">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div class="mb-4">
                                <label class="form-label">تأكيد كلمة المرور</label>
                                <input type="password"
                                       name="password_confirmation"
                                       class="form-control"
                                       required>

                                @error('password_confirmation')
                                    <div class="text-danger mt-1 small">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Button -->
                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-primary py-2">
                                    إعادة تعيين كلمة المرور
                                </button>
                            </div>

                            <!-- Back to login -->
                            <div class="text-center">
                                <a href="{{ route('login') }}"
                                   class="fw-bold text-decoration-none"
                                   style="color: #031f3d;">
                                    العودة إلى تسجيل الدخول
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
