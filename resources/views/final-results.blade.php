<x-main-layout pageTitle="Countries & Capitals Quiz">

    <div class="container">

        <div class="text-center fs-3 mb-3">
            <p class="text-info">RESULTADOS FINAIS</p>
        </div>

        <div class="row fs-3">
            <div class="col text-end">Total de questões:</div>
            <div class="col text-info">[TOTAL]</div>
        </div>
        <div class="row fs-3">
            <div class="col text-end">Respostas Certas:</div>
            <div class="col text-success">[TOTAL_CERTAS]</div>
        </div>
        <div class="row fs-3">
            <div class="col text-end">Respostas Erradas:</div>
            <div class="col text-danger">[TOTAL_ERRADAS]</div>
        </div>
        <div class="row fs-1">
            <div class="col text-end">Score Final:</div>
            <div class="col [conditional]">[00%]</div>
        </div>

    </div>

    <!-- next game -->
    <div class="text-center mt-5">
        <a href="{{ route('home') }}" class="btn btn-primary mt-3 px-5">VOLTAR AO INÍCIO</a>
    </div>
</x-main-layout>

