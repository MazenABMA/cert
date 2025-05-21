<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Models\Grade;
use App\Http\Controllers\Controller;

class GradeController extends Controller
{
    // Show grades grouped by terms
    public function list()
    {
        $grades = Grade::all()->groupBy('term');
        
        // Calculate total CH & GPA per term
        $gpa_per_term = [];
        $total_ch_per_term = [];
        foreach ($grades as $term => $term_grades) {
            $total_ch = $term_grades->sum('credit_hours');
            $total_points = $term_grades->sum(fn ($grade) => $grade->credit_hours * $this->gradeToPoint($grade->grade));
            $gpa_per_term[$term] = $total_ch ? round($total_points / $total_ch, 2) : 0;
            $total_ch_per_term[$term] = $total_ch;
        }

        // Calculate Cumulative CGPA & CCH
        $cumulative_ch = array_sum($total_ch_per_term);
        $cumulative_gpa = $cumulative_ch ? round(array_sum(array_map(fn ($term) => $total_ch_per_term[$term] * $gpa_per_term[$term], array_keys($total_ch_per_term))) / $cumulative_ch, 2) : 0;

        return view("grades.list", compact('grades', 'gpa_per_term', 'total_ch_per_term', 'cumulative_gpa', 'cumulative_ch'));
    }

    // Show add/edit form
    public function edit(Grade $grade = null)
    {
        $grade = $grade ?? new Grade();
        return view("grades.form", compact('grade'));
    }

    // Save new or updated grade
    public function save(Request $request, Grade $grade = null)
    {
        $grade = $grade ?? new Grade();
        $grade->fill($request->only(['course_name', 'term', 'credit_hours', 'grade']));
        $grade->save();
        return redirect()->route('grades_list');
    }

    // Delete a grade
    public function delete(Grade $grade)
    {
        $grade->delete();
        return redirect()->route('grades_list');
    }

    // Convert letter grades to GPA points
    private function gradeToPoint($grade)
    {
        return match ($grade) {
            'A' => 4.0, 'A-' => 3.7, 'B+' => 3.3, 'B' => 3.0, 'B-' => 2.7,
            'C+' => 2.3, 'C' => 2.0, 'C-' => 1.7, 'D+' => 1.3, 'D' => 1.0,
            'F' => 0.0, default => 0.0,
        };
    }
}
