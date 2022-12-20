<div class="hero-content text-center">
    <div class="max-w-md" id="div-2">
        @foreach($requisicoes as $requisicao)
        <h1 class="text-3xl font-bold">Olá {{$requisicao->NOME}}</h1>
        @endforeach
        <p class="py-10 text-xl">Qual a forma de agendamento do seu exame?</p>

        <div class="estrelas">
            <label for="cm_star-1"><i class="fa"></i></label>
            <input type="radio" id="cm_star-1" name="fb" value="1" />
            <label for="cm_star-2"><i class="fa"></i></label>
            <input type="radio" id="cm_star-2" name="fb" value="2" />
            <label for="cm_star-3"><i class="fa"></i></label>
            <input type="radio" id="cm_star-3" name="fb" value="3" />
        </div>
        <button href="#div-2" class="my-10 btn btn-primary">Avançar</button>
    </div>
</div>
