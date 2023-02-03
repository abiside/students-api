<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\StudentResource;
use App\Models\Course;

class CourseStudentsController extends Controller
{
    public function __invoke(Request $request, Course $course)
    {
        return StudentResource::collection($course->students);
    }
}
