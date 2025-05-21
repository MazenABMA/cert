<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = ['question_text', 'option_a', 'option_b', 'option_c', 'option_d', 'correct_answer'];

    public $timestamps = true;
}


