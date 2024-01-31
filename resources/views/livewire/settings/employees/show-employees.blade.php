<div>
    <div class="w-full text-right p-2">
        <x-primary-button wire:click="$set('confirmSync', 'true')">
            <x-icons.outline.refresh class="w-5 h-5"></x-icons.outline.refresh>
            Sincronizar
        </x-primary-button>
    </div>
    <div>
        {{$employees->links()}}
        <x-table>
            <x-slot:head>
                <x-table.heading>ID</x-table.heading>
                <x-table.heading>Nome</x-table.heading>
                <x-table.heading>Nome Social</x-table.heading>
                <x-table.heading>ID X-Clinic</x-table.heading>
                <x-table.heading>Ações</x-table.heading>
            </x-slot:head>
            <x-slot:body>
                @foreach($employees as $employee)
                    <x-table.row>
                        <x-table.cell>{{$employee->id}}</x-table.cell>
                        <x-table.cell>{{$employee->name}}</x-table.cell>
                        <x-table.cell>{{$employee->description_name}}</x-table.cell>
                        <x-table.cell>{{$employee->x_clinic_id}}</x-table.cell>
                        <x-table.cell><a type="button" class="cursor-pointer" wire:click="$dispatch('editEmployee', {employee: {{$employee->id}}})"><x-icons.outline.pencil-square class="w-6 h-6 text-primary"></x-icons.outline.pencil-square></a></x-table.cell>
                    </x-table.row>
                @endforeach
            </x-slot:body>
        </x-table>
    </div>
    <div>
        <x-modal wire:model="confirmSync">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    Tem certeza que deseja sincronizar os funcionários com o X-Clinic?
                </h2>

                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Evite fazer a sincronização em horários movimentados para não ocasionar problemas. Assim que
                    finalizada, verifique se os nomes estão corretos e se não há duplicidade.
                </p>
                <div class="mt-6 flex justify-end">
                    <x-secondary-button x-on:click="$dispatch('close')">
                        Cancelar
                    </x-secondary-button>

                    <x-primary-button class="ml-3" wire:click="synchronize">
                        Sincronizar
                    </x-primary-button>
                </div>
            </div>
        </x-modal>
    </div>
    @livewire('settings.employees.edit-employee')
</div>
