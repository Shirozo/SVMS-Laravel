<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CollegesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $colleges = [
            ['id' => 1, 'college_name' => 'College of Computer Studies'],
            ['id' => 2, 'college_name' => 'College of Engineering'],
            ['id' => 3, 'college_name' => 'College of Education'],
            ['id' => 4, 'college_name' => 'College of Technology'],
            ['id' => 5, 'college_name' => 'College of Apllied Science'],
            ['id' => 6, 'college_name' => 'College of Nursing and Allied Science'],
            ['id' => 7, 'college_name' => 'College of Business Management and Administration'],
            ['id' => 8, 'college_name' => 'College of Criminal Justice and Education'],
            ['id' => 9, 'college_name' => 'College of Agriculture'],
            ['id' => 10, 'college_name' => 'College of Hospitality Management'],
        ];

        DB::table('colleges')->insert($colleges);

    }
}
