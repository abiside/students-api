<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AttendancesIndexRequest;
use App\Http\Resources\AttendanceResource;
use App\Models\Attendance;
use App\Models\Course;

class AttendancesController extends Controller
{
    public function index(AttendancesIndexRequest $request, Course $course)
    {
        $attendances = Attendance::all();

        return AttendanceResource::collection($attendances);
    }
}
