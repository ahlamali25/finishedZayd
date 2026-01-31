@extends('layouts.app')

@section('title', 'تسجيل حساب جديد')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                <div class="row g-0">

                    <!-- الصورة -->
                    <div class="col-md-6 d-none d-md-block p-0">
                        <img src="{{ asset('img/reg.jpeg') }}" class="img-fluid w-100 h-100" style="object-fit: cover;">
                    </div>

                    <!-- الفورم -->
                    <div class="col-md-6 p-5" dir="rtl">
                        <h3 class="mb-4 text-center">إنشاء حساب</h3>

                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <!-- STEP 1 -->
                            <div class="step active" id="step1">
                                <div class="mb-3">
                                    <label class="form-label">الاسم الكامل</label>
                                    <input type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>
                                    @error('name')<div class="text-danger mt-1">{{ $message }}</div>@enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">البريد الإلكتروني</label>
                                    <input type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                                    @error('email')<div class="text-danger mt-1">{{ $message }}</div>@enderror
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">كلمة المرور</label>
                                    <input type="password" class="form-control" name="password" required>
                                    @error('password')<div class="text-danger mt-1">{{ $message }}</div>@enderror
                                </div>

                                <div class="d-grid">
                                    <button type="button" class="btn btn-primary" onclick="nextStep()">التالي</button>
                                </div>
                            </div>

                            <!-- STEP 2 -->
                            <div class="step" id="step2">

                                <div class="mb-3">
                                    <button type="button" onclick="prevStep()" class="btn btn-link p-0 text-decoration-none" style="font-size: 18px;">←</button>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">رقم الهاتف</label>
                                    <input type="tel" class="form-control" name="phone" value="{{ old('phone') }}" required>
                                    @error('phone')<div class="text-danger mt-1">{{ $message }}</div>@enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">الجنس</label>
                                    <select class="form-control" name="gender" required>
                                        <option disabled selected>اختر</option>
                                        <option value="female" {{ old('gender')=='female'?'selected':'' }}>أنثى</option>
                                        <option value="male" {{ old('gender')=='male'?'selected':'' }}>ذكر</option>
                                    </select>
                                    @error('gender')<div class="text-danger mt-1">{{ $message }}</div>@enderror
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">العمر</label>
                                    <input type="number" class="form-control" name="age" value="{{ old('age') }}" required>
                                    @error('age')<div class="text-danger mt-1">{{ $message }}</div>@enderror
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-success">إنشاء حساب</button>
                                </div>

                                <div class="text-center mt-3">
                                    <span>لديك حساب مسبق؟</span>
                                    <a href="{{ route('login') }}" class="fw-bold text-decoration-none" style="color: #031f3d;">تسجيل الدخول</a>
                                </div>

                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function nextStep() {
    document.getElementById('step1').classList.remove('active');
    document.getElementById('step2').classList.add('active');
}

function prevStep() {
    document.getElementById('step2').classList.remove('active');
    document.getElementById('step1').classList.add('active');
}
</script>
@endsection
