<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
public function run(): void
{
     User::create([
        'name' => 'جمانة دلال',
        'email' => 'jumanah@gmail.com',
        'password' => bcrypt('123456'),
        'role_id' => 2,
        'phone' => '0993376822',
        'gender' => 'Female',
        'age' => 35,
    ]);

     User::create([
        'name' => 'نبيها الغبرة',
        'email' => 'nabiha@gmail.com',
        'password' => bcrypt('123456'),
        'role_id' => 2,
        'phone' => '0993376823',
        'gender' => 'Female',
        'age' => 38,
    ]);

             User::create([
        'name' => 'حنان زينو',
        'email' => 'hanan@gmail.com',
        'password' => bcrypt('123456'),
        'role_id' => 2,
        'phone' => '0993376824',
        'gender' => 'Female',
        'age' => 40,
    ]);

                 User::create([
        'name' => 'أديبة درويش',
        'email' => 'adiba@gmail.com',
        'password' => bcrypt('123456'),
        'role_id' => 2,
        'phone' => '0993376825',
        'gender' => 'Female',
        'age' => 36,
    ]);

}
}
