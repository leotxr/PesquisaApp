<x-rating-layout>
    {{--RECEPCIONISTA--}}
    @livewire('forms.form-rating', ['rating' => $rating, 'fatura' => $fatura, 'text' => "Como você avalia o atendimento
    realizado pela recepcionista", 'label' => '', 'wire_function' => "avaliaRecepcao", 'photo' => $rating->employees()->first()->photo],
    key($rating->id))

    <?php 
        var_dump($rating->employees->where('role', 'rec'));
    ?>

    {{--AGENDAMENTO--}}
    @livewire('forms.form-rating', ['rating' => $rating, 'fatura' => $fatura, 'text' => "Como você avalia o agendamento
    realizado pelo(a) atendente", 'label' => $agendamento[0]->ATENDENTE, 'wire_function' => "avaliaAgendamento", 'photo' => '$rating->employees()->first()->photo'],
    key($rating->id))


    {{--TÉCNICOS E MÉDICOS--}}
    @foreach($fatura as $faturas)

        @if($faturas->enf_name)
            @php
                $enf = $faturas->employees()->where('role', 'enf')->first();
            @endphp
            @livewire('forms.form-rating', ['rating' => $rating, 'fatura' => $faturas, 'text' => "Como você avalia o atendimento
            realizado pelo(a) enfermeiro(a)", 'label' => $enf->description_name, 'photo' => $enf->photo, 'wire_function' => "avaliaEnfermeira"],
            key($faturas->id))
        @endif

        @if($faturas->us_name)
                @php
                    $usg = $faturas->employees()->where('role', 'usg')->first();
                @endphp
            @livewire('forms.form-rating', ['rating' => $rating, 'fatura' => $faturas, 'text' => "Como você avalia o atendimento
            realizado pela recepcionista", 'label' => $usg->description_name, 'wire_function' => "avaliaUSG", 'photo' => $usg->photo],
            key($faturas->id))
        @endif

        <livewire:forms.form-fatura :fatura="$faturas" :key="'form-fatura-'.$faturas->id"/>
    @endforeach

    {{--EMPRESA--}}
    @livewire('forms.form-rating', ['rating' => $rating, 'text' => "Como você avalia a", 'label' => "Ultrimagem",
    'wire_function' => "avaliaEmpresa", 'photo' => ''], key($rating->id))

</x-rating-layout>
