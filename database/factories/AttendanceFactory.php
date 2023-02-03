<?php

namespace Database\Factories;

use App\Models\Attendance;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Student;
use App\Models\Course;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Attendance>
 */
class AttendanceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'student_id' => function (array $attributes) {
                $studentsForCourseAndDate = $students = Attendance::where([
                    'course_id' => $attributes['course_id'],
                    'date' => $attributes['date'],
                ])->pluck('student_id');

                return Student::whereNotIn('id', $studentsForCourseAndDate)->get()->random()->id;
            },
            'course_id' => Course::all()->random()->id,
            'date' => fake()->date(),
            'is_present' => fake()->boolean(),
        ];
    }
}
