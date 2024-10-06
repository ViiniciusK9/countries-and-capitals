<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\View\View;

class MainController extends Controller
{
    private array $appData;

    public function __construct()
    {
        // load appData.php
        $this->appData = require(app_path('appData.php'));
    }

    public function index(): View
    {
        return view('home');
    }

    public function submit(Request $request): RedirectResponse
    {
        $request->validate(
            [
                'total_questions' => 'required|integer|min:3|max:30',
            ],
            [
                'total_questions.required' => 'O número de questões é obrigatorio',
                'total_questions.integer' => 'O número de questões tem que ser um valor inteiro',
                'total_questions.min' => 'No mínimo :min questões',
                'total_questions.max' => 'No máximo :max questões'
            ]
        );

        $totalQuestions = intval($request->get('total_questions'));

        $quiz = $this->prepareQuiz($totalQuestions);

        session()->put([
            'quiz' => $quiz,
            'total_questions' => $totalQuestions,
            'current_question' => 1,
            'correct_answers' => 0,
            'wrong_answers' => 0,
        ]);

        return redirect()->route('game');
    }

    public function game(): View
    {
        $quiz = session('quiz');
        $totalQuestions = session('total_questions');
        $currentQuestion = session('current_question') - 1;

        $answers = $quiz[$currentQuestion]['wrong_answers'];
        $answers[] = $quiz[$currentQuestion]['capital'];

        shuffle($answers);

        return view('game', [
            'country' => $quiz[$currentQuestion]['country'],
            'totalQuestions' => $totalQuestions,
            'currentQuestion' => $currentQuestion,
            'answers' => $answers,
        ]);
    }

    public function answer($encAnswer)
    {
        try {
            $answer = Crypt::decryptString($encAnswer);
        } catch (\Exception $e) {
            return redirect()->route('game');
        }

        $quiz = session('quiz');
        $currentQuestion = session('current_question') - 1;
        $totalQuestions = session('total_questions');
        $correctAnswer = $quiz[$currentQuestion]['capital'];
        $correctAnswers = session('correct_answers');
        $wrongAnswers = session('wrong_answers');

        if ($answer == $correctAnswer) {
            $correctAnswers++;
            $quiz[$currentQuestion]['correct'] = true;
        } else {
            $wrongAnswers++;
            $quiz[$currentQuestion]['correct'] = false;
        }

        session()->put([
            'quiz' => $quiz,
            'correct_answers' => $correctAnswers,
            'wrong_answers' => $wrongAnswers,
        ]);

        return view('answer-result', [
            'country' => $quiz[$currentQuestion]['country'],
            'correctAnswer' => $correctAnswer,
            'choiceAnswer' => $answer,
            'currentQuestion' => $currentQuestion,
            'totalQuestions' => $totalQuestions,
        ]);
    }

    public function nextQuestion()
    {
        $currentQuestion = session('current_question');
        $totalQuestions = session('total_questions');

        if ($currentQuestion < $totalQuestions) {
            $currentQuestion++;
            session()->put('current_question', $currentQuestion);
            return redirect()->route('game');
        }

        return redirect()->route('show-results');
    }

    public function showResults()
    {
        echo 'mostrar resultados finais';
        dd(session()->all());
    }

    private function prepareQuiz(int $totalQuestions): array
    {
        $questions = [];
        $totalCountries = count($this->appData);

        $indexes = range(0, $totalCountries - 1);
        shuffle($indexes);
        $indexes = array_slice($indexes, 0, $totalQuestions);

        $questionsNumber = 1;
        foreach ($indexes as $index) {
            $question['question_number'] = $questionsNumber++;
            $question['country'] = $this->appData[$index]['country'];
            $question['capital'] = $this->appData[$index]['capital'];

            // wrong answers
            $other_capitals = array_column($this->appData, 'capital');
            $other_capitals = array_diff($other_capitals, [$question['capital']]);
            shuffle($other_capitals);
            $question['wrong_answers'] = array_slice($other_capitals, 0, 3);

            $question['correct'] = null;

            $questions[] = $question;
        }

        return $questions;
    }
}
