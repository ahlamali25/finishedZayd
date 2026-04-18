@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <a href="{{ route('home') }}" class="btn btn-secondary mb-3">العودة للرئيسية</a>

    <div class="card shadow-sm">
        <div class="card-header"><h5>إضافة روابط التواصل الاجتماعي</h5></div>
        <div class="card-body">
            <form action="{{ route('teacher.social.store', $teacher->id) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="facebook_link" class="form-label">رابط فيسبوك</label>
                    <input type="url" name="facebook_link" id="facebook_link" class="form-control" placeholder="https://facebook.com/username">
                </div>
                <div class="mb-3">
                    <label for="instagram_link" class="form-label">رابط إنستغرام</label>
                    <input type="url" name="instagram_link" id="instagram_link" class="form-control" placeholder="https://instagram.com/username">
                </div>
                <button type="submit" class="btn btn-success">حفظ</button>
            </form>
        </div>
    </div>
</div>
@endsection