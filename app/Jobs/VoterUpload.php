<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class VoterUpload implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private array $data;
    private array $header;
    private array $courses;

    /**
     * Create a new job instance.
     *
     * @param array $data
     * @param array $header
     */
    public function __construct(array $data, array $header)
    {
        $this->data = $data;
        $this->header = $header;
        $this->courses = $this->getCourses();
    }

    /**
     * Retrieve the courses data.
     *
     * @return array
     */
    private function getCourses(): array
    {
        return [
            'bachelor of science in computer science' => 1,
            'bachelor of science in information technology' => 2,
            'bachelor of science in entertainment and multimedia computing' => 3,
            'associate in computer technology' => 4,
            'bachelor of science in electrical engineering' => 5,
            'bachelor of science in civil engineering' => 6,
            'bachelor of science in computer engineering' => 7,
            'bachelor of science in secondary education major in social studies' => 8,
            'bachelor of science in secondary education major in mathematics' => 9,
            'bachelor of science in secondary education major in science' => 10,
            'bachelor of science in secondary education major in english' => 11,
            'bachelor of science in secondary education major in filipino' => 12,
            'bachelor in elementary education' => 13,
            'bachelor of science in industrial technology major in automotive technology' => 14,
            'bachelor of science in industrial technology major in electronics technology' => 15,
            'bachelor of science in industrial technology major in electrical technology' => 16,
            'bachelor of science in industrial technology major in drafting technology' => 17,
            'bachelor of arts in communication' => 18,
            'bachelor of arts in political science' => 19,
            'bachelor of science in biology' => 20,
            'bachelor of science in social work' => 21,
            'bachelor of science in nursing' => 22,
            'diploma in midwifery leading to bachelor of science midwifery' => 23,
            'bachelor of science in entrepreneurship' => 24,
            'bachelor of science in accountancy' => 25,
            'bachelor of science in accounting information system' => 26,
            'bachelor of science in business administration major in financial management' => 27,
            'bachelor of science in business administration major in marketing management' => 28,
            'bachelor of science in business administration major in human resource development management' => 29,
            'bachelor of science in business administration major in business economics' => 30,
            'bachelor of science in criminology' => 31,
            'bachelor of science in agriculture major in animal science' => 32,
            'bachelor of science in agriculture major in agronomy' => 33,
            'bachelor of science in agriculture major in horticulture' => 34,
            'bachelor of science in environmental science' => 35,
            'bachelor of science in agricultural technology' => 36,
            'bachelor of science in fisheries' => 37,
            'bachelor of science in tourism management' => 38,
            'bachelor of science in hospitality management' => 39,
        ];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        foreach ($this->data as $d) {
            $voter = array_combine($this->header, $d);

            if ($voter === false) {
                Log::warning('Failed to combine header and data', ['header' => $this->header, 'data' => $d]);
                continue;
            }

            $username = $voter['student_id'] . "_" . $voter['last_name'];
            $password = $voter['last_name'] . "-" . $voter['student_id'];
            $course = strtolower($voter['course']);

            if (!isset($this->courses[$course])) {
                Log::warning('Course not found', ['course' => $course]);
                continue;
            }

            User::create([
                "first_name" => $voter['first_name'],
                "middle_name" => $voter['middle_name'],
                "last_name" => $voter['last_name'],
                "username" => $username,
                "student_id" => $voter['student_id'],
                "course_id" => $this->courses[$course],
                "year" => $voter['year'],
                "password" => $password,
            ]);
        }
    }
}
