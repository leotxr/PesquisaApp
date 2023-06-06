<div>
    <div class="h-screen hero bg-base-200">
        <div class="justify-center text-center hero-content">
            <form wire:submit.prevent="enviaComentario"name="formUltri" id="formUltri" method="POST">
                @csrf
                <div class="max-w-full">
                    <p class="py-10 text-3xl ">Deseja adicionar um <b>comentário</b> ou <b>sugestão?</b></p>

                    <textarea type="text" name="comentario" wire:model="comentario"
                        oninput='if(this.scrollHeight > this.offsetHeight) this.rows += 1'
                        placeholder="Comentários / Sugestões - (Opcional)"
                        class="justify-center w-full mb-10 text-xl textarea textarea-primary" autofocus></textarea>
                    <button type="submit" id="btn-end" href=""
                        class="my-10 text-white bg-blue-800 border-none hover:bg-blue-900 btn btn-wide">Finalizar</button>
                </div>
            </form>
        </div>
    </div>
</div>