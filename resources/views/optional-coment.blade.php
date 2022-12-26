<x-guest-layout>
    <form name="formUltri" id="formUltri" method="POST" action="{{route('sendComent')}}">
        @csrf
        <div class="hero h-screen bg-base-200">
            <div class="hero-content text-center justify-center">
                <div class="max-w-lg">
                    <p class=" text-3xl py-10">Deseja adicionar um <b>comentário</b> ou <b>sugestão?</b></p>
                    <input type="text" class="text-3xl font-bold" id="id" name="id" value="{{$id}}" style="display: none;"></input>

                    <textarea type="text" name="comentario" oninput='if(this.scrollHeight > this.offsetHeight) this.rows += 1' placeholder="Comentários / Sugestões" class="textarea textarea-primary w-full justify-center mb-10" autofocus></textarea>
                    <button type="submit" id="btn-end" href="" class="my-10 btn btn-primary btn-wide ">Finalizar</button>
                </div>
            </div>
        </div>
    </form>
</x-guest-layout>
<script>
    $(document).ready(function() {
        setTimeout(function() {
            window.location.href = "/";
        }, 60000);


    });
</script>
