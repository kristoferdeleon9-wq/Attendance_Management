<?php

namespace App\Http\Controllers;

use App\Models\Student;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

class StudentQrController extends Controller
{
    public function show(Student $student)
    {
        // Data stored inside the student's QR code
        $qrData = $student->student_id;

        $options = new QROptions([
            'eccLevel' => 'M',
            'scale' => 8,
            'outputBase64' => false,
            'svgAddXmlHeader' => false,
        ]);

        $qrCode = (new QRCode($options))->render($qrData);

        return view('students.qr', compact(
            'student',
            'qrCode'
        ));
    }
}