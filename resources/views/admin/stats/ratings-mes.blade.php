
<div class="stat">
    <div class="stat-title">Pesquisas realizadas </div>
    <div class="stat-value">{{$month}}</div>
    <div class="stat-desc">este mês</div>
</div>

<div class="stat">
    <div class="stat-title">Nota média da Clínica</div>
    <div class="stat-value">{{$avg = number_format($avg, 2,'.','')}}</div>
    <div class="stat-desc">no mes {{$hoje}}</div>
</div>

