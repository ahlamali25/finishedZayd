<!-- Navbar Start -->
<div class="container-fluid bg-light position-relative shadow">
    <nav class="navbar navbar-expand-lg bg-light navbar-light py-3 py-lg-0 px-0 px-lg-5">

        <!-- Logo -->
        <a href="{{ route('home') }}" class="navbar-brand font-weight-bold text-secondary" style="font-size: 50px">
            <img src="{{ asset('img/quran.png') }}" alt="quran" style="width: 60px; height: 60px;" />
            <span class="text-primary">مركز زيد بن ثابت</span>
        </a>

        <!-- Toggler -->
        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">

            <!-- Center Links -->
            <div class="navbar-nav font-weight-bold mx-auto py-0">

                <a href="{{ route('home') }}" class="nav-item nav-link active">الرئيسية</a>
                <a href="{{ route('center.page') }}" class="nav-item nav-link">عن المركز</a>
                <a href="{{ route('courses.index') }}" class="nav-item nav-link">الدورات</a>

                @auth

                    @php
                        $role = auth()->user()->role->role_name ?? null;
                    @endphp



                    @if ($role === 'student')
                        <a href="{{ route('dashboard') }}" class="nav-item nav-link">لوحة التحكم</a>
                    @elseif($role === 'teacher')
                        <a href="{{ route('teacher.dashboard') }}" class="nav-item nav-link">لوحة التحكم</a>
                    @elseif($role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="nav-item nav-link">لوحة التحكم</a>
                    @endif
                @endauth

            </div>

            <!-- Right Side -->
            <div class="d-flex align-items-center">

                @guest
                    <a href="{{ route('login') }}" class="btn btn-primary px-4 me-2">تسجيل الدخول</a>
                @endguest

                @auth
                    <ul class="navbar-nav">

                        <!-- Notifications -->
                        <li class="nav-item dropdown list-unstyled">

                            <a class="nav-link position-relative" data-toggle="dropdown" href="#">
                                🔔
                                <span id="notif-count" class="badge badge-danger position-absolute" style="top:0; right:0;">
                                    {{ auth()->user()->unreadNotifications->count() }}
                                </span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right">

                                @forelse(auth()->user()->notifications->take(5) as $notif)
                                    <div class="dropdown-item">
                                        {{ $notif->data['message'] }}
                                    </div>
                                @empty
                                    <div class="dropdown-item text-muted">
                                        لا توجد إشعارات
                                    </div>
                                @endforelse

                            </div>
                        </li>

                    </ul>

                    <form method="POST" action="{{ route('logout') }}" class="ms-2">
                        @csrf
                        <button type="submit" class="btn btn-danger px-4">تسجيل الخروج</button>
                    </form>
                @endauth

            </div>

        </div>
    </nav>
</div>
<!-- Navbar End -->


@auth
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {

                function subscribe() {
                    Echo.private('App.Models.User.{{ auth()->id() }}')
                        .notification(function(notification) {

                            const badge = document.getElementById('notif-count');
                            if (badge) {
                                let count = parseInt(badge.innerText) || 0;
                                badge.innerText = count + 1;
                            }

                            alert(notification.message ?? 'إشعار جديد');
                        });
                }

                if (typeof Echo === 'undefined') {
                    const waitForEcho = setInterval(function() {
                        if (typeof Echo !== 'undefined') {
                            clearInterval(waitForEcho);
                            subscribe();
                        }
                    }, 100);
                } else {
                    subscribe();
                }

            });
        </script>
    @endpush
@endauth
