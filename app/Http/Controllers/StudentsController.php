<?php

namespace App\Http\Controllers;

use App\Http\Resources\StudentResource;
use Illuminate\Http\Request;
use App\Models\Student;

class StudentsController extends Controller
{
    public function index()
    {
        return StudentResource::collection(Student::all());
    }
}
