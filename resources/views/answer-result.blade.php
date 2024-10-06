<x-main-layout pageTitle="Countries & Capitals Quiz">
    <div class="container">

        <x-question :$country :$currentQuestion :$totalQuestions ></x-question>

        <div class="text-center fs-3 mb-3">
            Resposta correta: <span class="text-info">{{ $correctAnswer }}</span>
        </div>

        <div class="text-center fs-3 mb-3">
            A sua resposta: <span class="[conditional]">{{ $choiceAnswer }}</span>
        </div>

    </div>

    <!-- cancel game -->
    <div class="text-center mt-5">
        <a href="{{ route('next-question') }}" class="btn btn-primary mt-3 px-5">AVANÇAR</a>
    </div>
</x-main-layout>
