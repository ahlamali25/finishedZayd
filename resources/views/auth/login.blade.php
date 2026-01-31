@extends('layouts.app')

@section('title', 'تسجيل الدخول')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">

            <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                <div class="row g-0">

                    <!-- العمود الأيسر (الصورة) -->
                    <div class="col-md-6 d-none d-md-block p-0">
                        <img src="{{ asset('img/child1.jpeg') }}" 
                             alt="login image" 
                             class="img-fluid w-100 h-100" 
                             style="object-fit: cover;">
                    </div>

                    <!-- العمود الأيمن (الفورم) -->
                    <div class="col-md-6 p-5" dir="rtl">
                        <h3 class="mb-4 text-center">تسجيل الدخول</h3>

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">البريد الإلكتروني</label>
                                <input type="email" name="email" 
                                       class="form-control" 
                                       placeholder="example@email.com" 
                                       value="{{ old('email') }}" 
                                       required autofocus>
                                @error('email')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label">كلمة المرور</label>
                                <input type="password" name="password" 
                                       class="form-control" 
                                       placeholder="********" 
                                       required>
                                @error('password')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-primary py-2">تسجيل الدخول</button>
                            </div>

                            <div class="text-center">
                                <span>لا تملك حساب؟</span>
                                <a href="{{ route('register') }}" 
                                   class="fw-bold text-decoration-none" 
                                   style="color: #031f3d;">إنشاء حساب</a>
                            </div>

                        </form>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
