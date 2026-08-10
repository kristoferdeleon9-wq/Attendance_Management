<?php

namespace App\Imports;

use App\Models\Student;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StudentsImport implements ToCollection, WithHeadingRow
{
    public int $imported = 0;
    public int $skipped = 0;

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {

            // Skip completely empty rows
            if ($row->filter()->isEmpty()) {
                continue;
            }

            $studentId = trim($row['student_id'] ?? '');
            $firstName = trim($row['first_name'] ?? '');
            $lastName = trim($row['last_name'] ?? '');
            $email = trim($row['email'] ?? '');
            $course = trim($row['course'] ?? '');
            $yearLevel = trim($row['year_level'] ?? '');

            // Check required fields
            if (
                empty($studentId) ||
                empty($firstName) ||
                empty($lastName) ||
                empty($course) ||
                empty($yearLevel)
            ) {
                $this->skipped++;
                continue;
            }

            // Prevent duplicate student IDs
            if (Student::where('student_id', $studentId)->exists()) {
                $this->skipped++;
                continue;
            }

            // Create student
            Student::create([
                'student_id' => $studentId,
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $email ?: null,
                'course' => $course,
                'year_level' => $yearLevel,
            ]);

            $this->imported++;
        }
    }
}