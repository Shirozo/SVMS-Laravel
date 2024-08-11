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
        $courses = [
            ['id' => 1,  'college_id' => 1, 'course_name' => 'Bachelor of Science in Computer Science'],
            ['id' => 2,  'college_id' => 1, 'course_name' => 'Bachelor of Science in Information Technology'],
            ['id' => 3,  'college_id' => 1, 'course_name' => 'Bachelor of Science in Entertainment and Multimedia Computing'],
            ['id' => 4,  'college_id' => 1, 'course_name' => 'Associate in Computer Technology'],
            ['id' => 5,  'college_id' => 2, 'course_name' => 'Bachelor of Science in Electrical Engineering'],
            ['id' => 6,  'college_id' => 2, 'course_name' => 'Bachelor of Science in Civil Engineering'],
            ['id' => 7,  'college_id' => 2, 'course_name' => 'Bachelor of Science in Computer Engineering'],
            ['id' => 8, 'college_id' => 3,  'course_name' => 'Bachelor of Science in Secondary Education Major in Social Studies'],
            ['id' => 9, 'college_id' => 3,  'course_name' => 'Bachelor of Science in Secondary Education Major in Mathematics'],
            ['id' => 10, 'college_id' => 3,  'course_name' => 'Bachelor of Science in Secondary Education Major in Science'],
            ['id' => 11, 'college_id' => 3,  'course_name' => 'Bachelor of Science in Secondary Education Major in English'],
            ['id' => 12, 'college_id' => 3,  'course_name' => 'Bachelor of Science in Secondary Education Major in Filipino'],
            ['id' => 13, 'college_id' => 3,  'course_name' => 'Bachelor in Elementary Education'],
            ['id' => 14,  'college_id' => 4, 'course_name' => 'Bachelor of Science in Industrial Technology Major in Autamotive Technology'],
            ['id' => 15,  'college_id' => 4, 'course_name' => 'Bachelor of Science in Industrial Technology Major in Electronics Technology'],
            ['id' => 16, 'college_id' => 4,  'course_name' => 'Bachelor of Science in Industrial Technology Major in Electrical Technology'],
            ['id' => 17, 'college_id' => 4,  'course_name' => 'Bachelor of Science in Industrial Technology Major in Drafting Technology'],
            ['id' => 18, 'college_id' => 5,  'course_name' => 'Bachelor of Arts in Communication'],
            ['id' => 19, 'college_id' => 5,  'course_name' => 'Bachelor of Arts in Political Science'],
            ['id' => 20, 'college_id' => 6,  'course_name' => 'Bachelor of Science in Biology'],
            ['id' => 21, 'college_id' => 6,  'course_name' => 'Bachelor of Science in Social Work'],
            ['id' => 22, 'college_id' => 6,  'course_name' => 'Bachelor of Science in Nursing'],
            ['id' => 23, 'college_id' => 6,  'course_name' => 'Diploma in Midwifery leading to Bachelor of Science Midwifery'],
            ['id' => 24, 'college_id' => 7,  'course_name' => 'Bachelor of Science in Entreprenuership'],
            ['id' => 25, 'college_id' => 7,  'course_name' => 'Bachelor of Science in Acountancy'],
            ['id' => 26, 'college_id' => 7,  'course_name' => 'Bachelor of Science in Acounting Information System'],
            ['id' => 27, 'college_id' => 7,  'course_name' => 'Bachelor of Science in Business Adminnitration Major in Financial Management'],
            ['id' => 28, 'college_id' => 7,  'course_name' => 'Bachelor of Science in Business Adminnitration Major in Marketing Management'],
            ['id' => 29, 'college_id' => 7,  'course_name' => 'Bachelor of Science in Business Adminnitration Major in Human Resource Development Management'],
            ['id' => 30, 'college_id' => 7,  'course_name' => 'Bachelor of Science in Business Adminnitration Major in Business Economics'],
            ['id' => 31,  'college_id' => 8, 'course_name' => 'Bachelor of Science in Criminology'],
            ['id' => 32,  'college_id' => 9, 'course_name' => 'Bachelor of Science in Agriculture Major in Animal Science'],
            ['id' => 33,  'college_id' => 9, 'course_name' => 'Bachelor of Science in Agriculture Major in Agronomy'],
            ['id' => 34,  'college_id' => 9, 'course_name' => 'Bachelor of Science in Agriculture Major in Horticulture'],
            ['id' => 35,  'college_id' => 9, 'course_name' => 'Bachelor of Science in Environmental Science'],
            ['id' => 36,  'college_id' => 9, 'course_name' => 'Bachelor of Science in Agricultural Technology'],
            ['id' => 37, 'college_id' => 9,  'course_name' => 'Bachelor of Science in Fisheries'],
            ['id' => 38, 'college_id' => 10,  'course_name' => 'Bachelor of Science in Tourism Management'],
            ['id' => 39, 'college_id' => 10,  'course_name' => 'Bachelor of Science in Hospitality Management'],
        ];

        DB::table("courses")->insert($courses);

    }
}
