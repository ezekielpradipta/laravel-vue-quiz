<?php

namespace App\Http\Controllers;

use App\Models\QuizQuestion;
use App\Http\Requests\StoreQuizQuestionRequest;
use App\Http\Requests\UpdateQuizQuestionRequest;
use Illuminate\Support\Str;
class QuizQuestionController extends Controller
{
    public function cobaa()
    {
        $random1 = Str::random(5);
        return response()->json($random1,200);
    }
}
