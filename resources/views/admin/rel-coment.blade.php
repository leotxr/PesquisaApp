<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Relatório de Comentários por Período') }}
        </h2>
    </x-slot>

    <div class="py-12" id="rel-coment">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg" id="datepicker">

            </div>
        </div>
        <div id="show-result">

        </div>
    </div>
</x-app-layout>

<script>
    $(document).ready(function() {
        $(document).ready(function() {
            const url = "{{ route('showdatepicker')}}";
            $.ajax({
                url: url,
                success: function(data) {
                    $("#datepicker").html(data);
                }
            });
        });
    });
/*
    $(document).ready(function() {
        $("#pick-date").click(function() {
            const url = "{{ route('resultByDate')}}";
            dataInicio = $("#data_inicio").val();
            dataFinal = $("#data_final").val();
            ordem = $("#ordem").val();
            $.ajax({
                url: url,
                data: {
                    'data_inicio': dataInicio,
                    'data_final': dataFinal,
                    'ordem': ordem
                },
                success: function(data) {
                    $("#show-result").html(data);
                }
            });
        });
    });
    */
</script>

