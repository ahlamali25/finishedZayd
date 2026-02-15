@extends('layouts.app') 
 
@section('title', 'تعديل الإعلان - مركز زيد بن ثابت') 
 
@section('content') 
<div class="container-fluid"> 
    <div class="row"> 
        <div class="col-12"> 
            <div class="card"> 
                <div class="card-header"> 
                    <h3 class="card-title"> 
                        <i class="fas fa-edit"></i> تعديل الإعلان 
                    </h3> 
                </div> 
                <div class="card-body"> 
                    <form action="{{ route('admin.announcements.update', $announcement) }}" method="POST"> 
                        @csrf 
                        @method('PUT') 
                         
                        <!-- معلومات أساسية --> 
                        <div class="row mb-4"> 
                            <div class="col-12"> 
                                <h5 class="mb-3"> 
                                    <i class="fas fa-info-circle"></i> معلومات أساسية 
                                </h5> 
                                <p class="text-muted">أدخل معلومات الإعلان الأساسية</p> 
                                 
                                <!-- حقل الكورس --> 
                                <div class="form-group mb-3"> 
                                    <label for="course_id" class="form-label"> 
                                        <i class="fas fa-book"></i> الكورس المطلوب (اختياري) 
                                    </label> 
                                    <select name="course_id" id="course_id" class="form-control form-select"> 
                                        <option value="">-- إعلان عام (لجميع الطلاب) --</option> 
                                        @foreach($courses as $course) 
                                            <option value="{{ $course->id }}"  
                                                {{ $announcement->course_id == $course->id ? 'selected' : '' }}> 
                                                {{ $course->name }} 
                                            </option> 
                                        @endforeach 
                                    </select> 
                                    <small class="form-text text-muted"> 
                                        <i class="fas fa-info-circle"></i> 
                                        الإعلان العام يظهر لجميع الطلاب. الإعلان الخاص فقط للعاملين في الكورس المطلوب. 
                                    </small> 
                                </div> 
                            </div> 
                        </div> 
                         
                        <!-- عنوان الإعلان --> 
                        <div class="row mb-4"> 
                            <div class="col-12"> 
                                <div class="form-group"> 
                                    <label for="title" class="form-label"> 
                                        <i class="fas fa-heading"></i> عنوان الإعلان 
                                    </label> 
                                    <input type="text"  
                                           name="title"  
                                           id="title"  
                                           class="form-control @error('title') is-invalid @enderror" 
                                           value="{{ old('title', $announcement->title) }}" 
                                           maxlength="255" 
                                           required> 
                                    @error('title') 
                                        <div class="invalid-feedback">{{ $message }}</div> 
                                    @enderror 
                                    <small class="form-text text-muted"> 
                                        اختر عنواناً واضحاً ومعبراً عن محتوى الإعلان
                                        <span id="title-counter" class="float-left">0/255 حرف</span> 
                                    </small> 
                                </div> 
                            </div> 
                        </div> 
                         
                        <!-- محتويات الإعلان --> 
                        <div class="row mb-4"> 
                            <div class="col-12"> 
                                <div class="form-group"> 
                                    <label for="content" class="form-label"> 
                                        <i class="fas fa-align-left"></i> محتويات الإعلان 
                                    </label> 
                                    <textarea name="content"  
                                              id="content"  
                                              class="form-control @error('content') is-invalid @enderror" 
                                              rows="8" 
                                              maxlength="5000" 
                                              required>{{ old('content', $announcement->content) }}</textarea> 
                                    @error('content') 
                                        <div class="invalid-feedback">{{ $message }}</div> 
                                    @enderror 
                                    <small class="form-text text-muted"> 
                                        اكتب تفاصيل الإعلان بشكل واضح وشامل 
                                        <span id="content-counter" class="float-left">0/5000 حرف</span> 
                                    </small> 
                                </div> 
                            </div> 
                        </div> 
                         
                        <!-- معلومات الناشر --> 
                        <div class="row mb-4"> 
                            <div class="col-12"> 
                                <div class="alert alert-info"> 
                                    <h6><i class="fas fa-user-edit"></i> معلومات التعديل</h6> 
                                    <div class="row"> 
                                        <div class="col-md-4"> 
                                            <strong>الناشر:</strong> {{ auth()->user()->name }} 
                                        </div> 
                                        <div class="col-md-4"> 
                                            <strong>البريد:</strong> {{ auth()->user()->email }} 
                                        </div> 
                                        <div class="col-md-4"> 
                                            <strong>تاريخ الإنشاء:</strong> {{ $announcement->created_at->format('d/m/Y - h:i A') }} 
                                        </div> 
                                    </div> 
                                </div> 
                            </div> 
                        </div> 
                         
                        <!-- أزرار التحكم --> 
                        <div class="row"> 
                            <div class="col-12"> 
                                <div class="d-flex justify-content-between"> 
                                    <a href="{{ route('admin.announcements.index') }}" class="btn btn-secondary"> 
                                        <i class="fas fa-times"></i> إلغاء 
                                    </a> 
                                    <button type="submit" class="btn btn-primary"> 
                                        <i class="fas fa-save"></i> تحديث الإعلان 
                                    </button> 
                                </div> 
                            </div> 
                        </div> 
                    </form>
                    </div> 
            </div> 
        </div> 
    </div> 
</div> 
@endsection 
 
@section('scripts') 
<script> 
    // عد الأحرف لعنوان الإعلان 
    const titleInput = document.getElementById('title'); 
    const titleCounter = document.getElementById('title-counter'); 
     
    titleInput.addEventListener('input', function() { 
        const length = this.value.length; 
        titleCounter.textContent = ${length}/255 حرف; 
        titleCounter.className = length > 255 ? 'float-left text-danger' : 'float-left text-muted'; 
    }); 
     
    // تحديث العداد عند التحميل 
    titleInput.dispatchEvent(new Event('input')); 
     
    // عد الأحرف للمحتوى 
    const contentInput = document.getElementById('content'); 
    const contentCounter = document.getElementById('content-counter'); 
     
    contentInput.addEventListener('input', function() { 
        const length = this.value.length; 
        contentCounter.textContent = ${length}/5000 حرف; 
        contentCounter.className = length > 5000 ? 'float-left text-danger' : 'float-left text-muted'; 
    }); 
     
    // تحديث العداد عند التحميل 
    contentInput.dispatchEvent(new Event('input')); 
</script> 
@endsection