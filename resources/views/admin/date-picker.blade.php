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
        <select id="med_name" name="med_name" class="select select-primary align-item-left max-w-xs">
            <option value="%">Todos os Livros</option>
            @foreach($rating as $ratings)
            <option value="{{$ratings->med_name}}">{{$ratings->med_name}}</option>
            @endforeach
        </select>
    </div>

    <div class="p-2 flex">
        <select id="ordem" name="ordem" class="select select-primary align-item-left max-w-xs">
            <option value="DATA" default>Ordenar por:</option>
            <option value="DATA">Data</option>
            <option value="RECEPCIONISTA">Recepcionista</option>
            <option value="ATENDENTE">Atendente</option>
            <option value="MEDICO">Médico</option>
        </select>
    </div>
    <a type="button" id="pick-date" class="my-2 btn btn-primary btn-wide ">Buscar</a>
</div>

<script>
    $("#rel-geral").show(function() {
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

    $("#rel-usg").show(function() {
        $("#pick-date").click(function() {
            const url = "{{ route('resultUSG')}}";
            dataInicio = $("#data_inicio").val();
            dataFinal = $("#data_final").val();
            ordem = $("#ordem").val();
            med_name = $("#med_name").val();
            $.ajax({
                url: url,
                data: {
                    'data_inicio': dataInicio,
                    'data_final': dataFinal,
                    'ordem': ordem,
                    'med_name': med_name
                },
                success: function(data) {
                    $("#show-result").html(data);
                }
            });
        });
    });

    $("#rel-coment").show(function() {
        $("#pick-date").click(function() {
            const url = "{{ route('resultComent')}}";
            dataInicio = $("#data_inicio").val();
            dataFinal = $("#data_final").val();
            $.ajax({
                url: url,
                data: {
                    'data_inicio': dataInicio,
                    'data_final': dataFinal
                },
                success: function(data) {
                    $("#show-result").html(data);
                }
            });
        });
    });
</script>
