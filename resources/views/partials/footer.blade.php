 <!-- Footer Start -->
    <div
      class="container-fluid bg-secondary text-white mt-5 py-5 px-sm-3 px-md-5"
    >
      <div class="row pt-5">
        <div class="col-lg-3 col-md-6 mb-5">
          <a
            href=""
            class="navbar-brand font-weight-bold text-primary m-0 mb-4 p-0"
            style="font-size: 40px; line-height: 40px"
          >
            <img src="{{ asset('img/quran.png') }}" alt="quran" style="width: 60px; height: 60px;" />
            <span class="text-white">مركز زيد بن ثابت</span>
          </a>
          <p>
          يسعى مركزنا لتحفيظ القرآن الكريم وتعليم العلوم الشرعية واللغة العربية حيث نسعى لتأمين التعلم للجميع سواء كانوا صغارا أو كبارا
          راجين من الله التوفيق والسداد في مسعانا هذا لخدمة كتاب الله تعالى وتعليم الناس الخير
          </p>
          <div class="d-flex justify-content-start mt-4">
            <a
              class="btn btn-outline-primary rounded-circle text-center mr-2 px-0"
              style="width: 38px; height: 38px"
              href="#"
              ><i class="fab fa-twitter"></i
            ></a>
            <a
              class="btn btn-outline-primary rounded-circle text-center mr-2 px-0"
              style="width: 38px; height: 38px"
              href="#"
              ><i class="fab fa-facebook-f"></i
            ></a>
            <a
              class="btn btn-outline-primary rounded-circle text-center mr-2 px-0"
              style="width: 38px; height: 38px"
              href="#"
              ><i class="fab fa-linkedin-in"></i
            ></a>
            <a
              class="btn btn-outline-primary rounded-circle text-center mr-2 px-0"
              style="width: 38px; height: 38px"
              href="#"
              ><i class="fab fa-instagram"></i
            ></a>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-5">
          <h3 class="text-primary mb-4">تواصل معنا</h3>
          <div class="d-flex">
            <h4 class="fa fa-map-marker-alt text-primary"></h4>
            <div class="pl-3">
              <h5 class="text-white">العنوان</h5>
              <p>123 سوريا, عفرين, الشارع</p>
            </div>
          </div>
          <div class="d-flex">
            <h4 class="fa fa-envelope text-primary"></h4>
            <div class="pl-3">
              <h5 class="text-white">البريد الإلكتروني</h5>
              <p>ZyadIbnThabit@academy.com</p>
            </div>
          </div>
          <div class="d-flex">
            <h4 class="fa fa-phone-alt text-primary"></h4>
            <div class="pl-3">
              <h5 class="text-white">الهاتف</h5>
              <p>+012 345 67890</p>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-5">
          <h3 class="text-primary mb-4">روابط سريعة</h3>
          <div class="d-flex flex-column justify-content-start">
            <a class="text-white mb-2" href="{{ route('home') }}"
              ><i class="fa fa-angle-right mr-2"></i>الرئيسية</a
            >
            <a class="text-white mb-2" href="{{ route('center.page') }}"
              ><i class="fa fa-angle-right mr-2"></i>عن المركز </a
            >
            <a class="text-white mb-2" href="{{ route('courses.index') }}"
              ><i class="fa fa-angle-right mr-2"></i>الدورات</a
            >
        
          </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-5">
          <h3 class="text-primary mb-4">تسجيل الدخول</h3>
        <form action="{{ route('login') }}" method="POST">
    @csrf

    <!-- البريد الإلكتروني -->
    <div class="form-group mb-3">
        <input
            type="email"
            name="email"
            class="form-control border-0 py-4"
            placeholder="البريد الإلكتروني"
            required
        />
    </div>

    <!-- كلمة المرور -->
    <div class="form-group mb-3">
        <input
            type="password"
            name="password"
            class="form-control border-0 py-4"
            placeholder="كلمة المرور"
            required
        />
    </div>

    <!-- زر تسجيل الدخول -->
    <div>
        <button
            class="btn btn-primary btn-block border-0 py-3"
            type="submit"
        >
            تسجيل الدخول
        </button>
    </div>
</form>

        </div>
      </div>
      <div
        class="container-fluid pt-5"
        style="border-top: 1px solid rgba(23, 162, 184, 0.2) ;"
      >
        <p class="m-0 text-center text-white">
          &copy;
          <a class="text-primary font-weight-bold" href="#">مركز زيد بن ثابت</a>.
          All Rights Reserved.

          <!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
          Designed by
          <a class="text-primary font-weight-bold" href="https://htmlcodex.com"
            >HTML Codex</a
          >
          <br />Distributed By:
          <a href="https://themewagon.com" target="_blank">ThemeWagon</a>
        </p>
      </div>
    </div>
    <!-- Footer End -->