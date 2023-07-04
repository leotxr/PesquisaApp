<div>
    <th scope="row" class="px-6 py-4 font-medium text-gray-900">
        {{$comment->comentario}}
    </th>
    <td class="px-6 py-4 whitespace-pre-line max-w-sm">
        @if($comment->setor == 'ULTRA-SON' || $comment->setor == 'CARDIOLOGIA' ) <b>
            {{$comment->livro_name}}</b> @else <b>{{$comment->tec_name}}</b> @endif

    </td>
    <td class="px-6 py-4">
        @if($comment->setor == 'ULTRA-SON' || $comment->setor == 'CARDIOLOGIA' ) <b>
            {{$comment->us_name}}</b> @else <b>{{$comment->enf_name}}</b> @endif
    </td>
    <td class="px-6 py-4">
        {{$comment->status_comentario_id}}
    </td>
    <td class="px-6 py-4 dropdown dropdown-left dropdown-end">
        <select name="status" wire:click='edit_status'
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
            @foreach($statuses as $status)
            <option value="{{$status->id}}">{{$status->name}}</option>
            @endforeach
        </select>
    </td>

</div>