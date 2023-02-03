<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AttendancesIndexRequest;
use App\Http\Requests\AttendancesStoreRequest;
use App\Http\Resources\AttendanceResource;
use App\Models\Attendance;
use App\Models\Student;
use App\Models\Course;

class AttendancesController extends Controller
{
    public function index(AttendancesIndexRequest $request, Course $course)
    {
        $attendances = Attendance::where('date', $request->get('date'))->get();

        return AttendanceResource::collection($attendances);
    }

    public function store(AttendancesStoreRequest $request, Course $course)
    {
        $attendance = Attendance::updateOrCreate(
            [
                'course_id' => $course->id,
                'student_id' => Student::where('student_id', $request->student_id)->first()->id,
                'date' => $request->date,
            ],
            [
                'is_present' => $request->is_present,
            ],
        );

        return AttendanceResource::make($attendance);
    }
}
