<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Resumo de pesquisas por período') }}
        </h2>
    </x-slot>

    <div class="py-12" id="rel-geral">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg justify-items-center text-center" id="">
                <div class="flex w-full">
                    <div class="flex flex-col w-full lg:flex-row">
                        <div class="grid flex-grow h-32 card bg-white-200 rounded-box place-items-center">
                            <label>Data Inicial</label>
                            <input type="date" id="data_inicio" placeholder="Data Inicial" value=""
                                class="input input-bordered input-primary w-full max-w-xs" />
                        </div>
                        <div class="divider lg:divider-horizontal">até</div>
                        <div class="grid flex-grow h-32 card bg-white-200 rounded-box place-items-center">
                            <label>Data Final</label>
                            <input type="date" id="data_final" placeholder="Data Final" value=""
                                class="input input-bordered input-primary w-full max-w-xs" />
                        </div>
                    </div>
                </div>
                <a type="button" id="pick-date" class="my-2 btn btn-primary btn-wide ">Buscar</a>
            </div>
        </div>
        <div id="show-result">

        </div>
    </div>
</x-app-layout>

<script>
$(document).ready(function() {
        $("#pick-date").click(function() {
            const url = "{{ route('report')}}";
            dataInicio = $("#data_inicio").val();
            dataFinal = $("#data_final").val();
            $.ajax({
                url: url,
                data: {
                    'data_inicio': dataInicio,
                    'data_final': dataFinal,
                },
                success: function(data) {
                    $("#show-result").html(data);
                }
            });
        });
    });
</script>
