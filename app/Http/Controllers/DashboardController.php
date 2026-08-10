<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\ClassModel;

class DashboardController extends Controller
{
    public function index()
    {
        $totalStudents = Student::count();
        $totalClasses = ClassModel::count();

        return view('dashboard', compact(
            'totalStudents',
            'totalClasses'
        ));
    }
}