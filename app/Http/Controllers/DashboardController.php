<?php

namespace App\Http\Controllers;

use App\Models\Student;

class DashboardController extends Controller
{
    public function index()
    {
        $totalStudents = Student::count();

        return view('dashboard', compact(
            'totalStudents'
        ));
    }
}