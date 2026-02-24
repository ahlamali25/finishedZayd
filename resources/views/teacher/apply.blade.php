@extends('layouts.app')

@section('title', 'تقديم طلب تدريس - مركز زيد بن ثابت')

@section('content')
    <div class="container py-5">

        <!-- Header -->
        <div class="text-center mb-4">
            <h1 class="text-primary fw-bold">
                <i class="fas fa-chalkboard-teacher me-2"></i>
                تقديم طلب تدريس
            </h1>
            <p class="text-muted mb-3">
                انضم إلى فريق المعلمين وساهم في صناعة جيل مميز 🌿
            </p>

            <!-- Trigger button to open wizard modal -->
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#applyModal">
                ابدأ تقديم الطلب
            </button>
        </div>

        <!-- Modal: Wizard -->
        <div class="modal fade" id="applyModal" tabindex="-1" role="dialog" aria-labelledby="applyModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="applyModalLabel">تقديم طلب تدريس</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="إغلاق">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <!-- Step Indicator -->
                        <div class="step-wrapper mb-4">
                            <div class="step active" data-step="1">
                                <div class="circle">1</div>
                                <span>المعلومات</span>
                            </div>
                            <div class="line"></div>
                            <div class="step" data-step="2">
                                <div class="circle">2</div>
                                <span>الخبرة</span>
                            </div>
                            <div class="line"></div>
                            <div class="step" data-step="3">
                                <div class="circle">3</div>
                                <span>الدافع</span>
                            </div>
                        </div>

                        <!-- Card -->
                        <div class="card border-0 shadow-lg form-card">
                            <div class="card-body p-4">

                                <form id="applicationForm" action="{{ route('teacher.apply.store') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf

                                    <!-- STEP 1 -->
                                    <div class="form-step active" id="step1">
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">التخصص *</label>
                                            <input type="text" class="form-control modern-input" name="specialization"
                                                required>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">شهادة الاختصاص (pdf/png/jpg) -
                                                اختياري</label>
                                            <input type="file" class="form-control" name="certificate"
                                                accept="application/pdf,image/*">
                                        </div>

                                        <div class="text-end">
                                            <button type="button" class="btn btn-primary btn-modern btn-next">
                                                التالي →
                                            </button>
                                        </div>
                                    </div>

                                    <!-- STEP 2 -->
                                    <div class="form-step" id="step2">
                                        <div class="mb-4">
                                            <label class="form-label fw-semibold">خبرتك في التدريس *</label>
                                            <textarea class="form-control modern-input" name="experience" rows="4" required minlength="50"></textarea>
                                            <small class="text-muted">حد أدنى 50 حرف</small>
                                        </div>

                                        <div class="d-flex justify-content-between">
                                            <button type="button" class="btn btn-light btn-modern btn-prev">←
                                                السابق</button>
                                            <button type="button" class="btn btn-primary btn-modern btn-next">التالي
                                                →</button>
                                        </div>
                                    </div>

                                    <!-- STEP 3 -->
                                    <div class="form-step" id="step3">
                                        <div class="mb-4">
                                            <label class="form-label fw-semibold">لماذا تريد التدريس معنا؟ *</label>
                                            <textarea class="form-control modern-input" name="motivation" rows="4" required minlength="50"></textarea>
                                        </div>

                                        <div class="d-flex justify-content-between">
                                            <button type="button" class="btn btn-light btn-modern btn-prev">←
                                                السابق</button>
                                            <button type="submit" class="btn btn-success btn-modern">إرسال الطلب ✓</button>
                                        </div>
                                    </div>

                                </form>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>

    @push('styles')
        <style>
            /* Card */
            .form-card {
                border-radius: 20px;
                transition: .3s ease;
            }

            .form-card:hover {
                transform: translateY(-4px);
            }

            /* Step Indicator */
            .step-wrapper {
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 15px;
            }

            .step {
                text-align: center;
                color: #6c757d;
            }

            .step .circle {
                width: 38px;
                height: 38px;
                border-radius: 50%;
                background: #e9ecef;
                display: flex;
                align-items: center;
                justify-content: center;
                font-weight: 600;
                margin: auto;
                transition: .3s ease;
            }

            .step.active .circle {
                background: #0d6efd;
                color: #fff;
            }

            .step.active span {
                color: #0d6efd;
                font-weight: 600;
            }

            .line {
                height: 2px;
                width: 40px;
                background: #dee2e6;
            }

            /* Inputs */
            .modern-input {
                border-radius: 12px;
                padding: 10px 14px;
                border: 1px solid #dee2e6;
                transition: .2s ease;
            }

            .modern-input:focus {
                border-color: #0d6efd;
                box-shadow: 0 0 0 3px rgba(13, 110, 253, .15);
            }

            /* Buttons */
            .btn-modern {
                border-radius: 50px;
                padding: 8px 20px;
                font-size: 14px;
            }

            /* Steps */
            .form-step {
                display: none;
                animation: fadeIn .3s ease;
            }

            .form-step.active {
                display: block;
            }

            /* Ensure modal inner content doesn't expand excessively */
            .modal-body {
                max-height: 65vh;
                overflow-y: auto;
            }

            @keyframes fadeIn {
                from {
                    opacity: 0;
                    transform: translateY(10px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            let currentStep = 1;
            const totalSteps = 3;

            document.querySelectorAll('.btn-next').forEach(btn => {
                btn.addEventListener('click', () => {
                    if (validateStep(currentStep)) nextStep();
                });
            });

            document.querySelectorAll('.btn-prev').forEach(btn => {
                btn.addEventListener('click', () => {
                    prevStep();
                });
            });

            function nextStep() {
                if (currentStep >= totalSteps) return;
                document.getElementById('step' + currentStep).classList.remove('active');
                document.querySelector('.step[data-step="' + currentStep + '"]').classList.remove('active');
                currentStep++;
                document.getElementById('step' + currentStep).classList.add('active');
                document.querySelector('.step[data-step="' + currentStep + '"]').classList.add('active');
            }

            function prevStep() {
                if (currentStep <= 1) return;
                document.getElementById('step' + currentStep).classList.remove('active');
                document.querySelector('.step[data-step="' + currentStep + '"]').classList.remove('active');
                currentStep--;
                document.getElementById('step' + currentStep).classList.add('active');
                document.querySelector('.step[data-step="' + currentStep + '"]').classList.add('active');
            }

            function validateStep(step) {
                const stepElement = document.getElementById('step' + step);
                if (!stepElement) return true;
                const inputs = stepElement.querySelectorAll('input, textarea');
                let ok = true;
                inputs.forEach(i => {
                    if (!i.checkValidity()) ok = false;
                });
                return ok;
            }
        </script>
    @endpush

@endsection
