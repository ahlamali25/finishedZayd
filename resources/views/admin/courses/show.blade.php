@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $course->name }}</h1>
        <p>{{ $course->description }}</p>
        <p>المدرس: {{ $course->teacher->user->name }}</p>
        <p>عدد الجلسات: {{ $course->total_sessions }}</p>

        <a href="{{ route('admin.courses.edit', $course) }}" class="btn btn-primary">تعديل</a>
        <form action="{{ route('admin.courses.destroy', $course) }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">حذف</button>
        </form>
    </div>
@endsection
