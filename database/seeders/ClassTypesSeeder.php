<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ClassTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('class_types')->insert([
            
            [
                'name' => 'براعم الجنة',
                'description' => 'نربي في براعم الجنة جيلاً يأنس بالقرآن، و يستظل بنوره، و يترعرع على آدابه وأخلاقه الطيبة',
                'age_from' => 6,
                'age_to' => 9,
                'start_time' => '08:00:00',
                'end_time' => '10:00:00',
                'image' => 'buds.png',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            [
                'name' => 'زهرات الإيمان',
                'description' => 'ننمي في أطفالنا حب القرآن وتجعلهم يعيشون مع قصصه ومواعظه بأسلوب بسيط قريب من قلوبهم',
                'age_from' => 10,
                'age_to' => 12,
                'start_time' => '08:00:00',
                'end_time' => '10:00:00',
                'image' => 'flower.jpeg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            [
                'name' => 'جيل الفرقان',
                'description' => 'نعدهم ليكونوا حفظة واعين، يجمعون بين الحفظ والفهم، ويتذوقون جمال البيان القرآني',
                'age_from' => 13,
                'age_to' => 15,
                'start_time' => '08:00:00',
                'end_time' => '10:00:00',
                'image' => 'furqan.jpeg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

           [
                'name' => 'روّاد الخير',
                'description' => 'نرعى شبابنا ليكونوا في الأخلاق والسلوك حاملين قيم القرآن في كل تفاصيل حياتهم  ',
                'age_from' => 16,
                'age_to' => 18,
                'start_time' => '08:00:00',
                'end_time' => '10:00:00',
                'image' => 'good.jpeg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

                       [
                'name' =>  'حملة القرآن'  ,
                'description' => 'ملتقى الكبار لتلاوة القرآن لتدبر معانيه وتجسيد قيمه في حياتهم اليومية ',
                'age_from' => 19,
                'age_to' => 80,
                'start_time' => '08:00:00',
                'end_time' => '10:00:00',
                'image' => 'quranCampaign.jpeg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

        ]);
    }
}
