<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Relatório de Avaliação por Setor') }}
        </h2>
    </x-slot>

    <div class="py-12" id="rel-usg">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b text-center border-gray-200">
                    <div class="flex w-full">
                        <div class="flex flex-col w-full lg:flex-row">
                            <div class="grid flex-grow h-32 card bg-white-200 rounded-box place-items-center">
                                <label>Data Inicial</label>
                                <input type="date" id="data_inicio" placeholder="Data Inicial" value="" class="input input-bordered input-primary w-full max-w-xs" />
                            </div>
                            <div class="divider lg:divider-horizontal">até</div>
                            <div class="grid flex-grow h-32 card bg-white-200 rounded-box place-items-center">
                                <label>Data Final</label>
                                <input type="date" id="data_final" placeholder="Data Final" value="" class="input input-bordered input-primary w-full max-w-xs" />
                            </div>
                        </div>
                    </div>
                    <div class="divider"></div>


                    <div class="p-2 flex">
                        <select id="setores" name="setores" class="select select-primary align-item-left max-w-xs">
                            <option value="0" default>Setores</option>
                            <option value="1">USG / Cardiologia</option>
                            <option value="2">Ressonância / Tomografia</option>
                            <option value="3">Radiologia</option>
                        </select>
                    </div>

                    <div class="p-2 flex">
                        <select id="ordem" name="ordem" class="select select-primary align-item-left max-w-xs">
                            <option value="data_req" default>Ordenar por:</option>
                            <option value="data_req">Data</option>
                            <option value="setor">Setor</option>
                            <option value="pac_name">Nome Paciente</option>
                            <option value="livro_name">Livro</option>
                        </select>
                    </div>
                    <a type="button" id="pick-date" class="my-2 btn btn-primary btn-wide ">Buscar</a>
                </div>

            </div>
        </div>
        <div id="show-result">

        </div>
    </div>
</x-app-layout>

<script>
    $("#pick-date").click(function() {
        const url = "{{ route('resultSetores')}}";
        dataInicio = $("#data_inicio").val();
        dataFinal = $("#data_final").val();
        ordem = $("#ordem").val();
        setores = $("#setores").val();
        $.ajax({
            url: url,
            data: {
                'data_inicio': dataInicio,
                'data_final': dataFinal,
                'ordem': ordem,
                'setores': setores
            },
            success: function(data) {
                $("#show-result").html(data);
            }
        });
    });
</script>