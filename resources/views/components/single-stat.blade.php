@props(['value'])
<div class="flex items-center p-4 bg-white rounded shadow-md">
    @isset($icon)
        {{$icon}}
    @endisset
    <!--

        <div class="flex flex-shrink-0 items-center justify-center bg-green-200 h-16 w-16 rounded">
            <x-icon name="arrow-up" class="w-6 h-6 text-green-700"></x-icon>

-->
    <div class="flex-grow flex flex-col ml-4">
        @isset($value)
            <span class="text-xl font-bold">{{$value}}</span>
        @endisset
        <div class="flex items-center justify-between">
            <span class="text-gray-500">{{$description}}</span>
            @isset($statistic)
                <span class="text-gray-500 text-sm font-semibold ml-2">{{$statistic}}</span>
            @endisset
        </div>
    </div>
</div>
