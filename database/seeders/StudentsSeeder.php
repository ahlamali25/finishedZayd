<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\ClassGroup;

class StudentsSeeder extends Seeder
{
    public function run(): void
    {
        $maxStudentsPerGroup = 30;

        User::factory(100)->create()->each(function ($user) use ($maxStudentsPerGroup) {

            $user->update([
                'role_id' => 3
            ]);

            // نجيب آخر مجموعة تابعة لبراعم الجنة
         $classGroup = ClassGroup::where('class_type_id', 1)
    ->orderBy('id', 'desc')
    ->first();

if (!$classGroup || $classGroup->users()->count() >= $classGroup->capacity) {

    $groupNumber = ClassGroup::where('class_type_id', 1)->count() + 1;

    $classGroup = ClassGroup::create([
        'group_number' => $groupNumber,
        'class_type_id' => 1,
        'capacity' => 30
    ]);

            }

            // ربط الطالبة بالمجموعة
           $user->classGroup()->attach($classGroup->id);
           $classGroup->increment('current_count');
        });
    }
}