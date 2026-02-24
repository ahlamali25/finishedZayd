<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>طلب تدريس جديد</title>
</head>
<body>
    <h3>تم تقديم طلب تدريس جديد</h3>

    <p>المتقدم: {{ $application->user->name }} ({{ $application->user->email }})</p>
    <p>التخصص: {{ $application->specialization }}</p>
    <p>الخبرة: {{ Str::limit($application->experience, 300) }}</p>
    <p>الدافع: {{ Str::limit($application->motivation, 300) }}</p>

    @if($application->certificate_path)
        <p>شهادة الاختصاص مرفقة: {{ $application->certificate_path }}</p>
    @endif

    <p>لمراجعة الطلب انتقل إلى لوحة التحكم الاداري.</p>
</body>
</html>