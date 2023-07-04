<div>
    <table id="table" class="w-full text-sm text-left text-gray-500">

        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Comentário
                </th>
                <th scope="col" class="px-6 py-3">
                    Médico/Técnico
                </th>
                <th scope="col" class="px-6 py-3">
                    Enfermeira/USG
                </th>
                <th scope="col" class="px-6 py-3">
                    Status
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($ratings as $rating)
            <tr class="bg-white border-b">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900">
                    {{$rating->comentario}}
                </th>
                <td class="px-6 py-4 whitespace-pre-line max-w-sm">
                    @if($rating->setor == 'ULTRA-SON' || $rating->setor == 'CARDIOLOGIA' ) <b>
                        {{$rating->livro_name}}</b> @else <b>{{$rating->tec_name}}</b> @endif

                </td>
                <td class="px-6 py-4">
                    @if($rating->setor == 'ULTRA-SON' || $rating->setor == 'CARDIOLOGIA' ) <b>
                        {{$rating->us_name}}</b> @else <b>{{$rating->enf_name}}</b> @endif
                </td>
                <td class="px-6 py-4">
                    {{$rating->status_comentario_id}}
                </td>
            </tr>
            @endforeach


        </tbody>

    </table>
</div>