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
            <x-slot name="statistic">{{$diff_yesterday}}%</x-slot>
        </x-single-stat>

        <x-single-stat value="{{$diff_last_month}}">
            <x-slot name="description">Avaliações no mês atual</x-slot>
            <x-slot name="value">{{$month}}</x-slot>
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
            <x-slot name="statistic">{{$diff_last_month}}%
            </x-slot>
        </x-single-stat>
    </div>
</div>

