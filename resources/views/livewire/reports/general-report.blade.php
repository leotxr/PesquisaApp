<div class="text-center bg-white dark:bg-gray-900">
    <form wire:submit='getReport'>
        @csrf
        <div class="p-2 my-2 bg-white shadow sm:p-4 sm:rounded-lg">
            <x-accordion>
                <x-slot name="title">
                    <div class="flex justify-start mx-2 font-bold text-gray-900">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 01-.659 1.591l-5.432 5.432a2.25 2.25 0 00-.659 1.591v2.927a2.25 2.25 0 01-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 00-.659-1.591L3.659 7.409A2.25 2.25 0 013 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0112 3z" />
                        </svg>
                        <h1>Filtros</h1>
                    </div>
                </x-slot>
                <x-slot name="content">
                    <div class="max-w-full">
                        <div class="grid content-center grid-cols-2 gap-4 sm:grid-cols-5">
                            <div>
                                <label for="initial_date" class="text-sm font-light text-gray-900 label">Data
                                    inicial</label>
                                <input type="date" wire:model='initial_date' id="initial_date"
                                    class="border-gray-300 input">
                            </div>
                            <div>
                                <label for="final_date" class="text-sm font-light text-gray-900 label">Data
                                    Final</label>
                                <input type="date" wire:model='final_date' id="final_date"
                                    class="border-gray-300 input">
                            </div>
                            <div>
                                <label for="submit" class="text-sm font-light text-gray-900 label">Gerar
                                    relatório</label>
                                <x-primary-button id="submit" type="submit">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                                    </svg>
                                    <span>Buscar</span>
                                </x-primary-button>
                            </div>

                        </div>
                    </div>
                </x-slot>
            </x-accordion>

        </div>
    </form>

    <div class="h-1">
        <div wire:loading>
            <span class="absolute inline-flex w-24 h-1 animate-bar bg-sky-500"></span>
        </div>
    </div>


    <div>
        {{-- GERAL --}}
        <x-stat>
            <x-slot name="title">
                <x-stat.title>
                    Total de Pesquisas Realizadas
                </x-stat.title>
            </x-slot>
            <x-slot name="content">
                <x-stat.content class="text-blue-600">
                    <x-slot name="icon" class="text-secondary">
                        <x-icon name="heart" class="inline-block w-8 h-8 stroke-current"></x-icon>
                    </x-slot>
                    <x-slot name="description">
                        Pesquisas realizadas
                    </x-slot>
                    {{ $total->count() }}
                </x-stat.content>
            </x-slot>
        </x-stat>

        @php
            $sectors = ['Cínica', 'Recepção', 'Recepção USG', 'Enfermagem', 'Técnicos', 'Médicos'];
        @endphp
        {{-- CLINICA --}}
        <x-stat>
            <x-slot name="title">
                <x-stat.title>
                    Resultado Clínica
                </x-stat.title>
            </x-slot>
            <x-slot name="content">
                <x-stat.content class="text-pink-600">
                    <x-slot name="icon" class="text-secondary">
                        <x-icon name="pencil-square" class="inline-block w-8 h-8 stroke-current"></x-icon>
                    </x-slot>
                    <x-slot name="description">
                        Avaliações respondidas
                    </x-slot>
                    {{ $total->whereNotNull('nota_clinica')->count() }}
                </x-stat.content>
                <x-stat.content class="text-blue-600">
                    <x-slot name="icon">
                        <x-icon name="hand-thumb-up" class="inline-block w-8 h-8 stroke-current"></x-icon>
                    </x-slot>
                    <x-slot name="description">
                        Notas Positivas
                    </x-slot>
                    {{ $total->where('nota_clinica', '>', 3)->count() }}
                </x-stat.content>
                <x-stat.content class="text-yellow-600">
                    <x-slot name="icon">
                        <x-icon name="emoji-neutral" class="inline-block w-7 h-7 text-yellow-600"></x-icon>
                    </x-slot>
                    <x-slot name="description">
                        Notas Regulares
                    </x-slot>
                    @if ($total->count() > 0)
                        {{ $total->where('nota_clinica', '=', 3)->count() }}
                        <p class="text-xs">
                            {{ number_format(($total->where('nota_clinica', '=', 3)->count() / $total->count()) * 100, 2, '.', '') }}%
                        </p>
                    @endif
                </x-stat.content>
                <x-stat.content class="text-red-600">
                    <x-slot name="icon">
                        <x-icon name="hand-thumb-down" class="inline-block w-8 h-8 stroke-current"></x-icon>
                    </x-slot>
                    <x-slot name="description">
                        Notas Negativas
                    </x-slot>
                    @if ($total->count() > 0)
                        {{ $total->where('nota_clinica', '<', 3)->count() }}
                        <p class="text-xs">
                            {{ number_format(
                                ($total->where('nota_clinica', '<', 3)->count() / $total->whereNotNull('nota_clinica')->count()) * 100,
                                2,
                                '.',
                                '',
                            ) }}%
                        </p>
                    @endif
                </x-stat.content>
                <x-stat.content class="text-green-600">
                    <x-slot name="icon">
                        <x-icon name="emoji-happy" class="inline-block w-8 h-8 stroke-current"></x-icon>
                    </x-slot>
                    <x-slot name="description">
                        Satisfação
                    </x-slot>
                    @if ($total->count() > 0)
                        {{ number_format(
                            ($total->where('nota_clinica', '>', 3)->count() / $total->whereNotNull('nota_clinica')->count()) * 100,
                            2,
                            '.',
                            '',
                        ) }}%
                    @endif
                </x-stat.content>
            </x-slot>
        </x-stat>
        
        {{-- RECEPCAO --}}
        <x-stat>
            <x-slot name="title">
                <x-stat.title>
                    Resultado Recepção
                </x-stat.title>
            </x-slot>
            <x-slot name="content">
                <x-stat.content class="text-pink-600">
                    <x-slot name="icon" class="text-secondary">
                        <x-icon name="pencil-square" class="inline-block w-8 h-8 stroke-current"></x-icon>
                    </x-slot>
                    <x-slot name="description">
                        Avaliações respondidas
                    </x-slot>
                    {{ $recep->count() }}
                </x-stat.content>
                <x-stat.content class="text-blue-600">
                    <x-slot name="icon">
                        <x-icon name="hand-thumb-up" class="inline-block w-8 h-8 stroke-current"></x-icon>
                    </x-slot>
                    <x-slot name="description">
                        Notas Positivas
                    </x-slot>
                    {{ $recep->where('recep_rate', '>', 3)->count() }}
                </x-stat.content>
                <x-stat.content class="text-yellow-600">
                    <x-slot name="icon">
                        <x-icon name="emoji-neutral" class="inline-block w-7 h-7 text-yellow-600"></x-icon>
                    </x-slot>
                    <x-slot name="description">
                        Notas Regulares
                    </x-slot>
                    @if ($recep->count() > 0)
                        {{ $recep->where('recep_rate', '=', 3)->count() }}
                        <p class="text-xs">
                            {{ number_format(($recep->where('recep_rate', '=', 3)->count() / $recep->count()) * 100, 2, '.', '') }}%
                        </p>
                    @endif
                </x-stat.content>
                <x-stat.content class="text-red-600">
                    <x-slot name="icon">
                        <x-icon name="hand-thumb-down" class="inline-block w-8 h-8 stroke-current"></x-icon>
                    </x-slot>
                    <x-slot name="description">
                        Notas Negativas
                    </x-slot>
                    @if ($recep->count() > 0)
                        {{ $recep->where('recep_rate', '<', 3)->count() }}
                        <p class="text-xs">
                            {{ number_format(($recep->where('recep_rate', '<', 3)->count() / $recep->count()) * 100, 2, '.', '') }}%
                        </p>
                    @endif
                </x-stat.content>
                <x-stat.content class="text-green-600">
                    <x-slot name="icon">
                        <x-icon name="emoji-happy" class="inline-block w-8 h-8 stroke-current"></x-icon>
                    </x-slot>
                    <x-slot name="description">
                        Satisfação
                    </x-slot>
                    @if ($recep->count() > 0)
                        {{ number_format(($recep->where('recep_rate', '>', 3)->count() / $recep->count()) * 100, 2, '.', '') }}%
                    @endif
                </x-stat.content>
            </x-slot>
        </x-stat>

        {{-- RECEPCAO AGENDAMENTO --}}
        <x-stat>
            <x-slot name="title">
                <x-stat.title>
                    Resultado Agendamento Recepção
                </x-stat.title>
            </x-slot>
            <x-slot name="content">
                <x-stat.content class="text-pink-600">
                    <x-slot name="icon" class="text-secondary">
                        <x-icon name="pencil-square" class="inline-block w-8 h-8 stroke-current"></x-icon>
                    </x-slot>
                    <x-slot name="description">
                        Avaliações respondidas
                    </x-slot>
                    {{ $recep_agd->count() }}
                </x-stat.content>
                <x-stat.content class="text-blue-600">
                    <x-slot name="icon">
                        <x-icon name="hand-thumb-up" class="inline-block w-8 h-8 stroke-current"></x-icon>
                    </x-slot>
                    <x-slot name="description">
                        Notas Positivas
                    </x-slot>
                    {{ $recep_agd->where('atend_rate', '>', 3)->count() }}
                </x-stat.content>
                <x-stat.content class="text-yellow-600">
                    <x-slot name="icon">
                        <x-icon name="emoji-neutral" class="inline-block w-7 h-7 text-yellow-600"></x-icon>
                    </x-slot>
                    <x-slot name="description">
                        Notas Regulares
                    </x-slot>
                    {{ $recep_agd->where('atend_rate', '=', 3)->count() }}
                </x-stat.content>
                <x-stat.content class="text-red-600">
                    <x-slot name="icon">
                        <x-icon name="hand-thumb-down" class="inline-block w-8 h-8 stroke-current"></x-icon>
                    </x-slot>
                    <x-slot name="description">
                        Notas Negativas
                    </x-slot>
                    {{ $recep_agd->where('atend_rate', '<', 3)->count() }}
                </x-stat.content>
                <x-stat.content class="text-green-600">
                    <x-slot name="icon">
                        <x-icon name="emoji-happy" class="inline-block w-8 h-8 stroke-current"></x-icon>
                    </x-slot>
                    <x-slot name="description">
                        Satisfação
                    </x-slot>
                    @if ($recep->count() > 0)
                        {{ number_format(($recep_agd->where('atend_rate', '>', 3)->count() / $recep_agd->count()) * 100, 2, '.', '') }}%
                    @endif
                </x-stat.content>
            </x-slot>
        </x-stat>

        {{-- USG --}}
        <x-stat>
            <x-slot name="title">
                <x-stat.title>
                    Resultado Recepção USG
                </x-stat.title>
            </x-slot>
            <x-slot name="content">
                <x-stat.content class="text-pink-600">
                    <x-slot name="icon" class="text-secondary">
                        <x-icon name="pencil-square" class="inline-block w-8 h-8 stroke-current"></x-icon>
                    </x-slot>
                    <x-slot name="description">
                        Avaliações respondidas
                    </x-slot>
                    {{ $usg->whereNotNull('us_rate')->count() }}
                </x-stat.content>
                <x-stat.content class="text-blue-600">
                    <x-slot name="icon">
                        <x-icon name="hand-thumb-up" class="inline-block w-8 h-8 stroke-current"></x-icon>
                    </x-slot>
                    <x-slot name="description">
                        Notas Positivas
                    </x-slot>
                    {{ $usg->where('us_rate', '>', 3)->count() }}
                </x-stat.content>
                <x-stat.content class="text-yellow-600">
                    <x-slot name="icon">
                        <x-icon name="emoji-neutral" class="inline-block w-7 h-7 text-yellow-600"></x-icon>
                    </x-slot>
                    <x-slot name="description">
                        Notas Regulares
                    </x-slot>
                    @if ($usg->count() > 0)
                        {{ $usg->where('us_rate', '=', 3)->count() }}
                        <p class="text-xs">
                            {{ number_format(($usg->where('us_rate', '=', 3)->count() / $usg->count()) * 100, 2, '.', '') }}%
                        </p>
                    @endif
                </x-stat.content>
                <x-stat.content class="text-red-600">
                    <x-slot name="icon">
                        <x-icon name="hand-thumb-down" class="inline-block w-8 h-8 stroke-current"></x-icon>
                    </x-slot>
                    <x-slot name="description">
                        Notas Negativas
                    </x-slot>
                    @if ($usg->count() > 0)
                        {{ $usg->where('us_rate', '<', 3)->count() }}
                        <p class="text-xs">
                            {{ number_format(($usg->where('us_rate', '<', 3)->count() / $usg->count()) * 100, 2, '.', '') }}%
                        </p>
                    @endif
                </x-stat.content>
                <x-stat.content class="text-green-600">
                    <x-slot name="icon">
                        <x-icon name="emoji-happy" class="inline-block w-8 h-8 stroke-current"></x-icon>
                    </x-slot>
                    <x-slot name="description">
                        Satisfação
                    </x-slot>
                    @if ($usg->count() > 0)
                        {{ number_format(($usg->where('us_rate', '>', 3)->count() / $usg->count()) * 100, 2, '.', '') }}%
                    @endif
                </x-stat.content>
            </x-slot>
        </x-stat>

        {{-- ENFERMAGEM --}}
        <x-stat>
            <x-slot name="title">
                <x-stat.title>
                    Resultado Enfermagem
                </x-stat.title>
            </x-slot>
            <x-slot name="content">
                <x-stat.content class="text-pink-600">
                    <x-slot name="icon" class="text-secondary">
                        <x-icon name="pencil-square" class="inline-block w-8 h-8 stroke-current"></x-icon>
                    </x-slot>
                    <x-slot name="description">
                        Avaliações respondidas
                    </x-slot>
                    {{ $enf->whereNotNull('enf_rate')->count() }}
                </x-stat.content>
                <x-stat.content class="text-blue-600">
                    <x-slot name="icon">
                        <x-icon name="hand-thumb-up" class="inline-block w-8 h-8 stroke-current"></x-icon>
                    </x-slot>
                    <x-slot name="description">
                        Notas Positivas
                    </x-slot>
                    {{ $enf->where('enf_rate', '>', 3)->count() }}
                </x-stat.content>
                <x-stat.content class="text-yellow-600">
                    <x-slot name="icon">
                        <x-icon name="emoji-neutral" class="inline-block w-7 h-7 text-yellow-600"></x-icon>
                    </x-slot>
                    <x-slot name="description">
                        Notas Regulares
                    </x-slot>
                    @if ($enf->count() > 0)
                        {{ $enf->where('enf_rate', '=', 3)->count() }}
                        <p class="text-xs">
                            {{ number_format(($enf->where('enf_rate', '=', 3)->count() / $enf->count()) * 100, 2, '.', '') }}%
                        </p>
                    @endif
                </x-stat.content>
                <x-stat.content class="text-red-600">
                    <x-slot name="icon">
                        <x-icon name="hand-thumb-down" class="inline-block w-8 h-8 stroke-current"></x-icon>
                    </x-slot>
                    <x-slot name="description">
                        Notas Negativas
                    </x-slot>
                    @if ($enf->count() > 0)
                        {{ $enf->where('enf_rate', '<', 3)->count() }}
                        <p class="text-xs">
                            {{ number_format(($enf->where('enf_rate', '<', 3)->count() / $enf->count()) * 100, 2, '.', '') }}%
                        </p>
                    @endif
                </x-stat.content>
                <x-stat.content class="text-green-600">
                    <x-slot name="icon">
                        <x-icon name="emoji-happy" class="inline-block w-8 h-8 stroke-current"></x-icon>
                    </x-slot>
                    <x-slot name="description">
                        Satisfação
                    </x-slot>
                    @if ($enf->count() > 0)
                        {{ number_format(
                            ($enf->where('enf_rate', '>', 3)->count() / $enf->whereNotNull('enf_rate')->count()) * 100,
                            2,
                            '.',
                            '',
                        ) }}%
                    @endif
                </x-stat.content>
            </x-slot>
        </x-stat>

        {{-- TECNICOS --}}
        <x-stat>
            <x-slot name="title">
                <x-stat.title>
                    Resultado Radiologia
                </x-stat.title>
            </x-slot>
            <x-slot name="content">
                <x-stat.content class="text-pink-600">
                    <x-slot name="icon" class="text-secondary">
                        <x-icon name="pencil-square" class="inline-block w-8 h-8 stroke-current"></x-icon>
                    </x-slot>
                    <x-slot name="description">
                        Avaliações respondidas
                    </x-slot>
                    {{ $tec->whereNotNull('livro_rate')->count() }}
                </x-stat.content>
                <x-stat.content class="text-blue-600">
                    <x-slot name="icon">
                        <x-icon name="hand-thumb-up" class="inline-block w-8 h-8 stroke-current"></x-icon>
                    </x-slot>
                    <x-slot name="description">
                        Notas Positivas
                    </x-slot>
                    {{ $tec->where('livro_rate', '>', 3)->count() }}
                </x-stat.content>
                <x-stat.content class="text-yellow-600">
                    <x-slot name="icon">
                        <x-icon name="emoji-neutral" class="inline-block w-7 h-7 text-yellow-600"></x-icon>
                    </x-slot>
                    <x-slot name="description">
                        Notas Regulares
                    </x-slot>
                    @if ($tec->count() > 0)
                        {{ $tec->where('livro_rate', '=', 3)->count() }}
                        <p class="text-xs">
                            {{ number_format(($tec->where('livro_rate', '=', 3)->count() / $tec->count()) * 100, 2, '.', '') }}%
                        </p>
                    @endif
                </x-stat.content>
                <x-stat.content class="text-red-600">
                    <x-slot name="icon">
                        <x-icon name="hand-thumb-down" class="inline-block w-8 h-8 stroke-current"></x-icon>
                    </x-slot>
                    <x-slot name="description">
                        Notas Negativas
                    </x-slot>
                    @if ($tec->count() > 0)
                        {{ $tec->where('livro_rate', '<', 3)->count() }}
                        <p class="text-xs">
                            {{ number_format(($tec->where('livro_rate', '<', 3)->count() / $tec->count()) * 100, 2, '.', '') }}%
                        </p>
                    @endif
                </x-stat.content>
                <x-stat.content class="text-green-600">
                    <x-slot name="icon">
                        <x-icon name="emoji-happy" class="inline-block w-8 h-8 stroke-current"></x-icon>
                    </x-slot>
                    <x-slot name="description">
                        Satisfação
                    </x-slot>
                    @if ($tec->count() > 0)
                        {{ number_format(($tec->where('livro_rate', '>', 3)->count() / $tec->count()) * 100, 2, '.', '') }}%
                    @endif
                </x-stat.content>
            </x-slot>
        </x-stat>

        {{-- MEDICOS --}}
        <x-stat>
            <x-slot name="title">
                <x-stat.title>
                    Resultado Médicos
                </x-stat.title>
            </x-slot>
            <x-slot name="content">
                <x-stat.content class="text-pink-600">
                    <x-slot name="icon" class="text-secondary">
                        <x-icon name="pencil-square" class="inline-block w-8 h-8 stroke-current"></x-icon>
                    </x-slot>
                    <x-slot name="description">
                        Avaliações respondidas
                    </x-slot>
                    {{ $med->whereNotNull('livro_rate')->count() }}
                </x-stat.content>
                <x-stat.content class="text-blue-600">
                    <x-slot name="icon">
                        <x-icon name="hand-thumb-up" class="inline-block w-8 h-8 stroke-current"></x-icon>
                    </x-slot>
                    <x-slot name="description">
                        Notas Positivas
                    </x-slot>
                    {{ $med->where('livro_rate', '>', 3)->count() }}
                </x-stat.content>
                <x-stat.content class="text-yellow-600">
                    <x-slot name="icon">
                        <x-icon name="emoji-neutral" class="inline-block w-7 h-7 text-yellow-600"></x-icon>
                    </x-slot>
                    <x-slot name="description">
                        Notas Regulares
                    </x-slot>
                    @if ($med->count() > 0)
                        {{ $med->where('livro_rate', '=', 3)->count() }}
                        <p class="text-xs">
                            {{ number_format(($med->where('livro_rate', '=', 3)->count() / $med->count()) * 100, 2, '.', '') }}%
                        </p>
                    @endif
                </x-stat.content>
                <x-stat.content class="text-red-600">
                    <x-slot name="icon">
                        <x-icon name="hand-thumb-down" class="inline-block w-8 h-8 stroke-current"></x-icon>
                    </x-slot>
                    <x-slot name="description">
                        Notas Negativas
                    </x-slot>
                    @if ($med->count() > 0)
                        {{ $med->where('livro_rate', '<', 3)->count() }}
                        <p class="text-xs">
                            {{ number_format(($med->where('livro_rate', '<', 3)->count() / $med->count()) * 100, 2, '.', '') }}%
                        </p>
                    @endif
                </x-stat.content>
                <x-stat.content class="text-green-600">
                    <x-slot name="icon">
                        <x-icon name="emoji-happy" class="inline-block w-8 h-8 stroke-current"></x-icon>
                    </x-slot>
                    <x-slot name="description">
                        Satisfação
                    </x-slot>
                    @if ($med->count() > 0)
                        {{ number_format(($med->where('livro_rate', '>', 3)->count() / $med->count()) * 100, 2, '.', '') }}%
                    @endif
                </x-stat.content>
            </x-slot>
        </x-stat>
    </div>
</div>
