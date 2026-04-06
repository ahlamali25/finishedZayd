<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User; 

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
           User::create([
        'name' => 'ثناء درويش',
        'email' => 'admin@gmail.com',
        'password' => bcrypt('123456'),
        'role_id' => 1,
        'phone' => '0993376821',
        'gender' => 'Female',
        'age' => 35,
    ]);
    }
}
