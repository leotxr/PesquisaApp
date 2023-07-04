<x-rating-layout>
    {{--RECEPCIONISTA--}}
    @livewire('forms.form-rating', ['rating' => $rating, 'fatura' => $fatura, 'text' => "Como você avalia o atendimento
    realizado pela recepcionista", 'label' => $rating->recep_name, 'wire_function' => "avaliaRecepcao"],
    key($rating->id))

    {{--TÉCNICOS E MÉDICOS--}}
    @foreach($fatura as $faturas)

    @if($faturas->enf_name)
    @livewire('forms.form-rating', ['rating' => $rating, 'fatura' => $faturas, 'text' => "Como você avalia o atendimento
    realizado pela enfermeira", 'label' => $faturas->enf_name, 'wire_function' => "avaliaEnfermeira"],
    key($faturas->id))
    @endif

    @if($faturas->us_name)
    @livewire('forms.form-rating', ['rating' => $rating, 'fatura' => $faturas, 'text' => "Como você avalia o atendimento
    realizado pela recepcionista", 'label' => $faturas->us_name, 'wire_function' => "avaliaUSG"],
    key($faturas->id))
    @endif

    <livewire:forms.form-fatura :fatura="$faturas" :key="'form-fatura-'.$faturas->id" />
    @endforeach

    {{--EMPRESA--}}
    @livewire('forms.form-rating', ['rating' => $rating, 'text' => "Como você avalia a", 'label' => "Ultrimagem",
    'wire_function' => "avaliaEmpresa"], key($rating->id))

</x-rating-layout>