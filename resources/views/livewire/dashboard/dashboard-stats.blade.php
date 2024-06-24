<div>
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-4" wire:poll.10000ms>

        <x-single-stat value="{{$diff_yesterday}}">
            <x-slot name="description">Avaliações realizadas hoje</x-slot>
            <x-slot name="value">{{$today}}</x-slot>
            <x-slot name="icon">
                            <span id="statistic_day">
                                @if($diff_yesterday > 0)
                                    <x-icon name="arrow-circle-up" class="text-green-600 w-8 h-8 fill-green-500"
                                            solid></x-icon>
                                @elseif($diff_yesterday == 0)
                                    <x-icon name="minus-circle" class="w-8 h-8 fill-yellow-400"
                                            solid></x-icon>
                                @else
                                    <x-icon name="arrow-circle-down" class="text-red-600 w-8 h-8 fill-red-500"
                                            solid></x-icon>
                                @endif
                            </span>
            </x-slot>
            <x-slot name="statistic">{{$diff_yesterday}}% <p class="text-xs">ontem</p></x-slot>
        </x-single-stat>

        <x-single-stat value="{{$diff_last_month}}">
            <x-slot name="description">Avaliações no mês atual</x-slot>
            <x-slot name="value">{{$month}}<p class="text-xs">{{now()->format('01/m') . ' - ' . now()->format('d/m')}}</p></x-slot>
            <x-slot name="icon">
                            <span id="statistic_month">
                            @if($diff_last_month > 0)
                                    <x-icon name="arrow-circle-up" class="w-8 h-8 fill-green-500"
                                            solid></x-icon>
                                @elseif($diff_last_month == 0)
                                    <x-icon name="minus-circle" class="w-8 h-8 fill-yellow-400"
                                            solid></x-icon>
                                @else
                                    <x-icon name="arrow-circle-down" class="w-8 h-8 fill-red-500"
                                            solid></x-icon>
                                @endif
                        </span>
            </x-slot>
            <x-slot name="statistic"><p class="text-md">{{$diff_last_month}}%</p><p class="text-xs">{{now()->subMonths(1)->format('01/m') . ' - ' . now()->subMonths(1)->format('d/m')}}</p>
            </x-slot>
        </x-single-stat>

        <x-single-stat>
            <x-slot name="description">Comentários no mês atual</x-slot>
            <x-slot name="value">{{$month_comments}}</x-slot>
            <x-slot name="icon">
                <span id="statistic_month">
                    <x-icon name="chat-alt" class="w-8 h-8 fill-blue-500" solid></x-icon>
                </span>
            </x-slot>
        </x-single-stat>

        <x-single-stat>
            <x-slot name="description">Satisfação no mês atual <span class="text-xs">(Nota clínica)</span></x-slot>
            <x-slot name="value">{{$satisfaction}}%</x-slot>
            <x-slot name="icon">
                <span id="statistic_month">
                    @if($satisfaction >= 97.00)
                        <x-icon name="new-emoji-happy" class="w-8 h-8 fill-green-500"
                                solid></x-icon>
                    @elseif($satisfaction > 50.00 && $satisfaction < 97.00)
                        <x-icon name="new-emoji-neutral" class="w-8 h-8 fill-yellow-400"
                                solid></x-icon>
                    @else
                        <x-icon name="new-emoji-angry" class="w-8 h-8 fill-red-500"
                                solid></x-icon>
                    @endif
                        </span>
            </x-slot>
        </x-single-stat>
    </div>
</div>

