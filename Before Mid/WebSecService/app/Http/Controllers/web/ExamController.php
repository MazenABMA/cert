<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Http\Controllers\Controller;

class ExamController extends Controller
{
    // Show Question Management Page
    public function manageQuestions()
    {
        $questions = Question::all();
        return view("exam.questions_list", compact('questions'));
    }

    // Show add/edit question form
    public function editQuestion(Question $question = null)
    {
        $question = $question ?? new Question();
        return view("exam.question_form", compact('question'));
    }

    // Save new or updated question
    public function saveQuestion(Request $request, Question $question = null)
    {
        $question = $question ?? new Question();
        $question->fill($request->only(['question_text', 'option_a', 'option_b', 'option_c', 'option_d', 'correct_answer']));
        $question->save();
        return redirect()->route('exam_manage_questions');
    }


    // Delete a question
    public function deleteQuestion(Question $question)
    {
        $question->delete();
        return redirect()->route('exam_manage_questions');
    }

    // Show Start Exam Page
    public function startExam()
    {
        $questions = Question::all();
        return view("exam.start_exam", compact('questions'));
    }

    // Submit Exam & Calculate Score
    public function submitExam(Request $request)
    {
        $score = 0;
        $totalQuestions = Question::count();
        
        foreach ($request->answers as $question_id => $user_answer) {
            $question = Question::find($question_id);
            if ($question && $question->correct_answer == $user_answer) {
                $score++;
            }
        }

        $percentage = ($totalQuestions > 0) ? round(($score / $totalQuestions) * 100, 2) : 0;

        return view("exam.exam_result", compact('score', 'totalQuestions', 'percentage'));
    }

}

