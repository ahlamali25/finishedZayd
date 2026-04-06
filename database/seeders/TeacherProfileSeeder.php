<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TeacherProfileSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('teachers')->insert([
            [
                'user_id' => 1, // ثناء درويش
                'specialization' => 'السيرةالنبوية',
                'status' => 'full_time',
            ],
            [
                'user_id' => 2, // جمانة دلال
                'specialization' => 'تفسير',
                'status' => 'full_time',
            ],
            [
                'user_id' => 3, // نبيها الغبرة
                'specialization' => 'لغة عربية',
                'status' => 'part_time',
            ],
            [
                'user_id' => 4, // حنان زينو
                'specialization' => 'فقه العبادات',
                'status' => 'full_time',
            ],
            [
                'user_id' => 5, // أديبة درويش
                'specialization' => 'حديث',
                'status' => 'part_time',
            ],
        ]);
    }
}