<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>حالة طلب التدريس</title>
</head>
<body>
    @if($status === 'approved')
        <h3>تهانينا — تم قبول طلبك للتدريس</h3>
        <p>مرحباً {{ $application->user->name }},</p>
        <p>لقد تم قبول طلبك للتدريس. يمكنك الآن تسجيل الدخول والوصول للميزات المخصصة للمعلمين.</p>
    @else
        <h3>تم رفض طلب التدريس</h3>
        <p>مرحباً {{ $application->user->name }},</p>
        <p>نأسف لإبلاغك أن طلبك للتدريس تم رفضه. إذا رغبت بمعرفة السبب، تواصل مع الإدارة.</p>
    @endif

    <p>مع التحية،<br>فريق مركز زيد بن ثابت</p>
</body>
</html>