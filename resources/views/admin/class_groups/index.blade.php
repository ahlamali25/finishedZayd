@extends('admin.layout')

@section('content')
    <style>
        .stats-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none !important;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(102, 126, 234, 0.4) !important;
        }

        .stats-card.card-1 {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .stats-card.card-2 {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }

        .stats-card.card-3 {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }

        .stats-card.card-4 {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        }

        .stats-card.card-5 {
            background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        }

        /* icon removed to keep title clear and avoid overlap */

        .stat-value {
            font-size: 2.5rem;
            font-weight: bold;
            margin: 0.5rem 0;
        }

        .stat-label {
            font-size: 0.9rem;
            opacity: 0.9;
            margin-top: 0.5rem;
        }

        .table-container {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .table thead {
            background: linear-gradient(135deg, #4da1b4 0%, #64dada 100%);
            color: white;
        }

        .table thead th {
            border: none;
            padding: 1.2rem !important;
            font-weight: 600;
            font-size: 0.95rem;
        }

        .table tbody tr {
            border-bottom: 1px solid #e9ecef;
            transition: all 0.2s ease;
        }

        .table tbody tr:hover {
            background-color: #f8f9fa;
        }

        .table tbody td {
            padding: 1.2rem !important;
            vertical-align: middle;
        }

        .class-name-strong {
            color: #4da1b4;
            font-weight: 600;
            font-size: 1.05rem;
        }

        .badge-class {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-size: 0.85rem;
            margin: 0.2rem;
            font-weight: 500;
        }

        .badge-course {
            display: inline-block;
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
            color: white;
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-size: 0.85rem;
            margin: 0.2rem;
            font-weight: 500;
        }

        .page-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }

        .page-title i {
            color: #4da1b4;
            font-size: 2rem;
        }

        .section-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 1.5rem;
            padding-bottom: 0.8rem;
            border-bottom: 3px solid #64dada;
            display: inline-block;
        }

        .no-data {
            text-align: center;
            padding: 2rem;
            color: #7f8c8d;
            font-style: italic;
        }

        .teacher-name {
            color: #e67e22;
            font-weight: 600;
        }
    </style>

    <div class="pb-4">
        <h4 class="page-title">
            <i class="bi bi-diagram-3"></i>
            إدارة الحلقات
        </h4>

        <!-- Stats Cards -->
        <div class="row mb-5">
            @foreach ($classTypes as $index => $classType)
                @php
                    $totalSubGroups = $classType->classGroups()->count();
                    $totalStudents = $classType
                        ->classGroups()
                        ->with('users')
                        ->get()
                        ->sum(fn($group) => $group->users()->count());
                    $teacher = $classType->classGroups()->first()?->teacher;
                    $cardClass = 'card-' . (($index % 5) + 1);
                @endphp
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card stats-card {{ $cardClass }} p-4 h-100">

                        <h5 style="font-weight: 600; margin-bottom: 1rem; padding-inline-start: 0.6rem;">
                            {{ $classType->name }}</h5>

                        <div style="margin-bottom: 1.5rem;">
                            <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem;">
                                <i class="bi bi-collection"></i>
                                <small style="opacity: 0.9;">الحلقات الفرعية</small>
                            </div>
                            <div class="stat-value">{{ $totalSubGroups }}</div>
                        </div>

                        <div style="margin-bottom: 1.5rem;">
                            <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem;">
                                <i class="bi bi-people"></i>
                                <small style="opacity: 0.9;">عدد الطلاب</small>
                            </div>
                            <div class="stat-value">{{ $totalStudents }}</div>
                        </div>

                        <div>
                            <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem;">
                                <i class="bi bi-person-badge"></i>
                                <small style="opacity: 0.9;">المعلمة</small>
                            </div>
                            @if ($teacher && $teacher->user)
                                <p style="font-weight: 600; margin: 0;">{{ $teacher->user->name }}</p>
                            @else
                                <p style="margin: 0; opacity: 0.8;">غير محدد</p>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Courses Table -->
        <div>
            <h5 class="section-title">
                <i class="bi bi-table" style="margin-left: 0.5rem;"></i>
                الحلقات الأساسية والكورسات
            </h5>

            <div class="table-container">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th width="25%">
                                <i class="bi bi-book" style="margin-left: 0.5rem;"></i>
                                الحلقة الأساسية
                            </th>
                            <th width="35%">
                                <i class="bi bi-diagram-3" style="margin-left: 0.5rem;"></i>
                                الحلقات الفرعية
                            </th>
                            <th width="40%">
                                <i class="bi bi-mortarboard" style="margin-left: 0.5rem;"></i>
                                الكورسات
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($classTypes as $classType)
                            <tr>
                                <td>
                                    <span class="class-name-strong">{{ $classType->name }}</span>
                                </td>
                                <td>
                                    @php
                                        $groups = $classType->classGroups()->get();
                                    @endphp
                                    @if ($groups->count() > 0)
                                        <div>
                                            @foreach ($groups as $group)
                                                <span class="badge-class">
                                                    <i class="bi bi-circle-fill"
                                                        style="font-size: 0.5rem; margin-left: 0.3rem;"></i>
                                                    الحلقة {{ $group->group_number }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="no-data" style="display: inline;">—</span>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $courses = $classType
                                            ->classGroups()
                                            ->with('courses')
                                            ->get()
                                            ->flatMap(fn($group) => $group->courses)
                                            ->unique('id');
                                    @endphp
                                    @if ($courses->count() > 0)
                                        <div>
                                            @foreach ($courses as $course)
                                                <span class="badge-course">
                                                    <i class="bi bi-checkmark-circle-fill" style="margin-left: 0.3rem;"></i>
                                                    {{ $course->name }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="no-data" style="display: inline;">—</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="no-data">
                                    <i class="bi bi-inbox"
                                        style="font-size: 2rem; display: block; margin-bottom: 0.5rem;"></i>
                                    لا توجد حلقات في النظام
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
