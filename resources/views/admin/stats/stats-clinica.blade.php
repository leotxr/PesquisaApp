
<div id="stack" class="stack cursor-pointer m-2">
    <div class="stats bg-success text-success-content">

        <div class="stat">
            <div class="stat-title">Total de Notas positivas</div>
            <div class="stat-value">{{$positivas}}</div>
        </div>

    </div>

    <div class="stats bg-warning text-warning-content my-5">

        <div class="stat">
            <div class="stat-title">Total de Notas neutras</div>
            <div class="stat-value">{{$neutras}}</div>
        </div>
    </div>


    <div class="stats bg-error text-error-content my-5">

        <div class="stat">
            <div class="stat-title">Total de Notas negativas</div>
            <div class="stat-value">{{$negativas}}</div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#stack").click(function() {
            $(this).toggleClass("stack");
        });
    });
</script>
