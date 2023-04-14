<div>
    <div class="hero h-screen bg-base-200">
        <div class="hero-content text-center justify-center">
            <form wire:submit.prevent="enviaComentario"name="formUltri" id="formUltri" method="POST">
                @csrf
                <div class="max-w-full">
                    <p class=" text-3xl py-10">Deseja adicionar um <b>comentário</b> ou <b>sugestão?</b></p>

                    <textarea type="text" name="comentario" wire:model="comentario"
                        oninput='if(this.scrollHeight > this.offsetHeight) this.rows += 1'
                        placeholder="Comentários / Sugestões - (Opcional)"
                        class="textarea textarea-primary w-full justify-center mb-10 text-xl" autofocus></textarea>
                    <button type="submit" id="btn-end" href=""
                        class="btn btn-primary btn-wide my-10 ">Finalizar</button>
                </div>
            </form>
        </div>
    </div>
</div>