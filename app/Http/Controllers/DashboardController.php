<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\ClassModel;
use App\Models\Teacher;

class DashboardController extends Controller
{
    public function index()
    {
        $totalStudents = Student::count();
        $totalTeachers = Teacher::count();
        $totalClasses = ClassModel::count();

        return view('dashboard', compact(
            'totalStudents',
            'totalTeachers',
            'totalClasses'
        ));
    }
}