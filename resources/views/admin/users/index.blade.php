@extends('admin.layout')

@section('content')

<h4 class="mb-3">المستخدمون</h4>

<!-- Search -->
<form method="GET" class="mb-4">
    <div class="input-group">
        <input type="text"
               name="course"
               class="form-control"
               placeholder="ابحث باسم الكورس"
               value="{{ request('course') }}">
        <button class="btn btn-primary">بحث</button>
    </div>
</form>

<!-- Students -->
<div class="card card-box p-3 mb-4">
    <h5 class="mb-3">الطلاب</h5>

    <table class="table table-bordered text-center align-middle">
        <thead>
            <tr>
                <th>الاسم</th>
                <th>الإيميل</th>
                <th>الهاتف</th>
                <th>العمر</th>
                <th>الحلقات</th>
                <th>الكورسات</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $student)
                <tr>
                    <td>{{ $student->name }}</td>
                    <td>{{ $student->email }}</td>
                    <td>{{ $student->phone }}</td>
                    <td>{{ $student->age }}</td>
                    <td>
                        @foreach($student->classGroup as $group)
                            <span class="badge bg-secondary">
                                {{ $group->name }}
                            </span>
                        @endforeach
                    </td>
                    <td>
                        @foreach($student->courses as $course)
                            <span class="badge bg-info text-dark">
                                {{ $course->name }}
                            </span>
                        @endforeach
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Teachers -->
<div class="card card-box p-3">
    <h5 class="mb-3">المعلمين</h5>

    <table class="table table-bordered text-center align-middle">
        <thead>
            <tr>
                <th>الاسم</th>
                <th>الإيميل</th>
                <th>الهاتف</th>
                <th>العمر</th>
                <th>الكورسات</th>
            </tr>
        </thead>
        <tbody>
            @foreach($teachers as $teacher)
                <tr>
                    <td>{{ $teacher->name }}</td>
                    <td>{{ $teacher->email }}</td>
                    <td>{{ $teacher->phone }}</td>
                    <td>{{ $teacher->age }}</td>
                    <td>
                        @foreach($teacher->teacher->courses as $course)
                            <span class="badge bg-warning text-dark">
                                {{ $course->name }}
                            </span>
                        @endforeach
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
