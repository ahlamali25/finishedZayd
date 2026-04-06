<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CoursesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      DB::table('courses')->insert([
            
            [
                'name' =>  'اللغة العربية',
                'description' => ' المستوى الأول : الحروف الهجائية، التعرف على الحروف، كتابة الحروف، نطق الحروف',
                'total_sessions' => 40,
                'teacher_id' => 3,
            ],

            [
                'name' =>  'الفقه',
                'description' => ' المستوى الأول : الطهارة، الصلاة، الزكاة، الصوم',
                 'total_sessions' => 40,
                'teacher_id' => 4,
            ],

            [
                'name' =>  'التفسير',
                'description' => ' المستوى الأول : تفسير الجزء الثلاثون من القرآن الكريم',
                 'total_sessions' => 40,
                'teacher_id' => 2,
            ],

           [
                'name' =>  'رياض الصالحين',
                'description' => ' المستوى الأول : رياض الصالحين من حديث رقم 1 إلى حديث رقم 50',
                 'total_sessions' => 40,
                'teacher_id' => 1,
            ],

           [
                'name' =>  'التجويد (النور المبين)',
                'description' => ' المستوى الأول :  شرح مخارج الحروف وصفاتهاو بقية أحكام التجويد ',
                'total_sessions' => 40,
                'teacher_id' => 5,
            ],

            [
                'name' =>  'الجزرية',
                'description' => ' المستوى الأول : متن الجزرية مع شرح بعض الأحكام التجويدية الواردة فيه',
                'total_sessions' => 40,
                'teacher_id' => 5,
            ],

        ]);
    }
}
