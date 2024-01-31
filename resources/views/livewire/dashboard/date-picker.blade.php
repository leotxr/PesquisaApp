<div>
    <form wire:submit='search'>
        <div wire:loading.remove class="grid sm:grid-cols-3 gap-8 text-center content-center bg-white">
            <div>
                <x-input-label for="date_1" class="label">
                    Data Inicial
                </x-input-label>
                <input wire:model.live='initial_date' id="date_1" type="date" class="input input-bordered">
            </div>
            <div>
                <x-input-label for="date_2" class="label">
                    Data Final
                </x-input-label>
                <input wire:model.live='final_date' id="date_2" type="date" class="input input-bordered">
            </div>
            <div class="p-8">
                <x-primary-button type="submit">Buscar</x-primary-button>
            </div>
        </div>
    </form>
    <div wire:loading>
        Aguarde, buscando dados...
    </div>
</div>