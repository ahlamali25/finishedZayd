@extends('layouts.app')

@section('title', $course->name)

@section('content')
    <div class="container py-5">
        <div class="row">
            <div class="col-12">
                <h1 class="mb-4 text-primary">{{ $course->name }}</h1>
                <p class="mb-4">{{ $course->description ?? 'لا يوجد وصف لهذه الدورة.' }}</p>

                @if ($course->lessons && $course->lessons->count())
                    <h4 class="mb-3">الدروس</h4>
                    <ul class="list-group mb-4">
                        @foreach ($course->lessons as $lesson)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>{{ $lesson->title }}</span>
                                <a href="{{ route('lessons.show', $lesson->id) }}"
                                    class="btn btn-sm btn-outline-primary">عرض</a>
                            </li>
                        @endforeach
                    </ul>
                @endif

                <a href="{{ route('courses.index') }}" class="btn btn-secondary">رجوع إلى الدورات</a>
            </div>
        </div>
    </div>
@endsection
