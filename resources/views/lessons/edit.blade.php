
<!-- resources/views/lessons/edit.blade.php -->
@extends('layouts.app')

@section('title', 'تعديل درس - مركز زيد بن ثابت')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">
                        <i class="fas fa-edit me-2"></i>تعديل درس
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('lessons.update', $lesson->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="title" class="form-label">عنوان الدرس *</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror"
                                   id="title" name="title" value="{{ old('title', $lesson->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="video_link" class="form-label">رابط الفيديو (اختياري)</label>
                            <input type="url" class="form-control @error('video_link') is-invalid @enderror"
                                   id="video_link" name="video_link" value="{{ old('video_link', $lesson->video_link) }}"
                                   placeholder="https://www.youtube.com/watch?v=...">
                            @error('video_link')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="date" class="form-label">تاريخ الدرس *</label>
                            <input type="date" class="form-control @error('date') is-invalid @enderror"
                                   id="date" name="date" value="{{ old('date', $lesson->date) }}" required>
                            @error('date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('lessons.learn', $lesson->course_id) }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-right me-2"></i>رجوع
                            </a>
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-save me-2"></i>تحديث الدرس
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection