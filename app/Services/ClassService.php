<?php

namespace App\Services;

use App\Models\ClassType;
use App\Models\ClassGroup;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\ClassAcceptanceMail;

class ClassService
{
    public function joinClass($user, $classTypeId)
    {
        // تحقق من أن المستخدم ليس معلم
        if ($user->role->role_name === 'teacher') {
            throw new \Exception('هذه الخدمة غير متوفرة للمعلمين في الوقت الراهن. قريباً جداً سيتم السماح للمعلمين بالانضمام للحلقات.');
        }

        $classType = ClassType::findOrFail($classTypeId);

        // تحقق العمر
        if ($user->age < $classType->age_from ||
            ($classType->age_to && $user->age > $classType->age_to)) {
            throw new \Exception('عمرك لا يتناسب مع متطلبات الحلقة.');
        }

        // منع التكرار
        $alreadyJoined = ClassGroup::where('class_type_id', $classTypeId)
            ->whereHas('users', function ($q) use ($user) {
                $q->where('users.id', $user->id);
            })
            ->exists();

        if ($alreadyJoined) {
            throw new \Exception('أنت مسجل مسبقًا في هذه الحلقة');
        }

        // البحث عن مجموعة متاحة
        $group = ClassGroup::where('class_type_id', $classTypeId)
            ->whereColumn('current_count', '<', 'capacity')
            ->orderBy('group_number')
            ->first();

        // إنشاء مجموعة إذا لم توجد
        if (! $group) {
            $lastGroup = ClassGroup::where('class_type_id', $classTypeId)
                ->orderBy('group_number', 'desc')
                ->first();

            $group = ClassGroup::create([
                'group_number' => $lastGroup ? $lastGroup->group_number + 1 : 1,
                'capacity' => 30,
                'current_count' => 0,
                'class_type_id' => $classTypeId,
            ]);
        }

        // ربط المستخدم
        $group->users()->attach($user->id);
        // تحديث class_group_id في جدول المستخدمين
        $user->update(['class_group_id' => $group->id]);
        $group->increment('current_count');

        // إرسال الإيميل
        Mail::to($user->email)->send(
            new ClassAcceptanceMail($user->name, $classType->name)
        );

        return $group;
    }
}