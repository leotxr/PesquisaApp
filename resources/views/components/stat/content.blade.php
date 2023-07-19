<div {{ $attributes->merge(['class' => 'stat']) }}>
    <div {{ $attributes->merge(['class' => 'stat-figure']) }}>
        {{$icon}}
    </div>
    <div class="stat-title">{{$description}}</div>
    <div {{ $attributes->merge(['class' => 'stat-value']) }}>{{ $slot }}</div>
</div>