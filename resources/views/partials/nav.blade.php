  <!-- Navbar Start -->
  <div class="container-fluid bg-light position-relative shadow">
      <nav class="navbar navbar-expand-lg bg-light navbar-light py-3 py-lg-0 px-0 px-lg-5">
          <a href="" class="navbar-brand font-weight-bold text-secondary" style="font-size: 50px">
              <img src="{{ asset('img/quran.png') }}" alt="quran" style="width: 60px; height: 60px;" />

              <span class="text-primary">مركز زيد بن ثابت</span>
          </a>
          <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
              <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
              <div class="navbar-nav font-weight-bold mx-auto py-0">
                  <a href="{{ route('home') }}" class="nav-item nav-link active">الرئيسية</a>
                  <a href="about.html" class="nav-item nav-link">عن المركز</a>
                  <a href="{{ route('courses.index') }}" class="nav-item nav-link">الدورات</a>
                  <a href="team.html" class="nav-item nav-link">المعلمات</a>
                  <a href="gallery.html" class="nav-item nav-link">التواصل معنا</a>


              </div>
           @guest
    <a href="{{ route('login') }}" class="btn btn-primary px-4">
        تسجيل الدخول
    </a>
@endguest

@auth
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn btn-danger px-4">
            تسجيل الخروج
        </button>
    </form>
@endauth


          </div>
      </nav>
  </div>
  <!-- Navbar End -->
