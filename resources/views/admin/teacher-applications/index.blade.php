<!-- resources/views/admin/teacher-applications/index.blade.php -->
@extends('layouts.app')

@section('title', 'إدارة طلبات التدريس')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>
            <i class="bi bi-person-lines-fill me-2"></i>
            طلبات التدريس
        </h4>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>المتقدم</th>
                            <th>البريد الإلكتروني</th>
                            <th>التخصص</th>
                            <th>تاريخ التقديم</th>
                            <th>الحالة</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($applications as $index => $app)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $app->user->name }}</td>
                            <td>{{ $app->user->email }}</td>
                            <td>{{ $app->specialization }}</td>
                            <td>{{ $app->created_at->format('Y-m-d') }}</td>
                            <td>
                                @if($app->status == 'pending')
                                    <span class="badge bg-warning">قيد المراجعة</span>
                                @elseif($app->status == 'approved')
                                    <span class="badge bg-success">تمت الموافقة</span>
                                @else
                                    <span class="badge bg-danger">مرفوض</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.teacher-applications.show', $app->id) }}"
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <i class="bi bi-inbox display-4 text-muted"></i>
                                <p class="mt-3">لا توجد طلبات</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection