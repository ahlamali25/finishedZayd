<!-- resources/views/lessons/create.blade.php -->
@extends('layouts.app')

@section('title', 'إضافة درس جديد - مركز زيد بن ثابت')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-plus-circle me-2"></i>إضافة درس جديد
                        </h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('lessons.store', ['course' => $course]) }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="title" class="form-label">عنوان الدرس *</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror"
                                    id="title" name="title" value="{{ old('title') }}" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="video_link" class="form-label">رابط الفيديو (اختياري)</label>
                                <input type="url" class="form-control @error('video_link') is-invalid @enderror"
                                    id="video_link" name="video_link" value="{{ old('video_link') }}"
                                    placeholder="https://www.youtube.com/watch?v=...">
                                @error('video_link')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">يمكنك إضافة رابط من اليوتيوب أو أي منصة أخرى</div>
                            </div>

                            <div class="mb-3">
                                <label for="date" class="form-label">تاريخ الدرس *</label>
                                <input type="date" class="form-control @error('date') is-invalid @enderror"
                                    id="date" name="date" value="{{ old('date', date('Y-m-d')) }}" required>
                                @error('date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="time" class="form-label">وقت الدرس (اختياري)</label>
                                <input type="time" class="form-control @error('time') is-invalid @enderror"
                                    id="time" name="time" value="{{ old('time') }}">
                                @error('time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>



                            <div class="d-flex justify-content-between">
                                <a href="{{ route('lessons.learn', $course->id) }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-right me-2"></i>رجوع
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>حفظ الدرس
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
