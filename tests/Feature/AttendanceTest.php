<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Attendance;
use App\Models\Course;
use App\Models\Student;

class AttendanceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Indicates whether the default seeder should run before each test.
     *
     * @var bool
     */
    protected $seed = true;

    public function test_it_throws_an_exception_for_non_existing_course()
    {
        $response = $this->json('get', '/api/v1/courses/2/attendances?date=');

        $response->assertStatus(404);
    }

    public function test_it_throws_an_exception_for_missing_date()
    {
        $response = $this->json('get', '/api/v1/courses/1/attendances?date=');

        $response
            ->assertStatus(422)
            ->assertJsonPath('message', 'The date field is required.');
    }

    public function test_it_returns_an_empty_attendances_array()
    {
        $response = $this->json('get', '/api/v1/courses/1/attendances?date=2023-01-01');

        $response
            ->assertOk()
            ->assertJsonCount(0, 'data');
    }

    public function test_it_returns_an_empty_attendances_array_because_different_dates()
    {
        for ($i = 1; $i <= 3; $i++) {
            Attendance::factory()->create([
                'course_id' => 1,
                'date' => '2023-01-02',
            ]);
        }    

        $response = $this->json('get', '/api/v1/courses/1/attendances?date=2023-01-01');

        $response
            ->assertOk()
            ->assertJsonCount(0, 'data');
    }

    public function test_it_returns_a_list_of_three_attendances_were_just_created()
    {
        for ($i = 1; $i <= 3; $i++) {
            Attendance::factory()->create([
                'course_id' => 1,
                'date' => '2023-01-01',
            ]);
        }    

        $response = $this->json('get', '/api/v1/courses/1/attendances?date=2023-01-01');

        $response
            ->assertOk()
            ->assertJsonCount(3, 'data');
    }

    public function test_it_returns_a_list_of_five_attendances_for_the_given_date()
    {
        $dates = [
            '2023-01-01',
            '2023-01-02',
            '2023-01-03',
        ];

        $dateToQuery = '2023-01-01';

        foreach ($dates as $date) {
            $randAmount = rand(1,15);

            if ($date == $dateToQuery) {
                $totalResult = $randAmount;
            }

            for ($i = 1; $i <= $randAmount; $i++) {
                Attendance::factory()->create([
                    'course_id' => 1,
                    'date' => $date,
                ]);
            }
        };

        $response = $this->json('get', "/api/v1/courses/1/attendances?date={$dateToQuery}");

        $response
            ->assertOk()
            ->assertJsonCount($totalResult, 'data');
    }

    public function test_it_tries_to_save_attendance_and_throw_exception_for_missing_date()
    {
        $response = $this->json('post', "/api/v1/courses/1/attendances", [
            'student_id' => 1691091750799,
            'is_present' => true,
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonPath('message', 'The date field is required.');
    }

    public function test_it_saves_a_new_attendance()
    {
        $student = Student::inRandomOrder()->first();

        $response = $this->json('post', "/api/v1/courses/1/attendances", [
            'date' => '2023-01-01',
            'student_id' => $student->student_id,
            'is_present' => true,
        ]);

        $response->assertCreated()
            ->assertJson([
                'data' => [
                    'date' => '2023-01-01',
                    'student_id' => $student->student_id,
                    'is_present' => true,
                    'course_id' => 1,
                ]
            ]);
    }

    public function test_it_updates_an_existing_attendance()
    {
        $student = Student::inRandomOrder()->first();

        $response = $this->json('post', "/api/v1/courses/1/attendances", [
            'date' => '2023-01-01',
            'student_id' => $student->student_id,
            'is_present' => true,
        ]);

        $response->assertCreated()
            ->assertJson([
                'data' => [
                    'date' => '2023-01-01',
                    'student_id' => $student->student_id,
                    'is_present' => true,
                    'course_id' => 1,
                ]
            ]);

        $response = $this->json('post', "/api/v1/courses/1/attendances", [
            'date' => '2023-01-01',
            'student_id' => $student->student_id,
            'is_present' => false,
        ]);

        $response->assertOk()
            ->assertJson([
                'data' => [
                    'date' => '2023-01-01',
                    'student_id' => $student->student_id,
                    'is_present' => false,
                    'course_id' => 1,
                ]
            ]);
    }
}
