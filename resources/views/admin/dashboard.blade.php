<x-app-layout id="dashboard">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 text-center">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-base-200 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-base border-b border-base-200">
                    <div class="flex flex-wrap justify-center">
                    
                        <div class="stats stats-vertical lg:stats-horizontal shadow m-2" id="statstoday">

                        </div>

                        <div class="stats stats-vertical lg:stats-horizontal shadow m-2" id="statsmonth">

                        </div>

                        <div class="stats stats-vertical lg:stats-horizontal shadow m-2" id="statsyear">

                        </div>

                        <div id="statscount">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script>
    $(document).ready(function() {
        $("#dashboard").ready(function() {
            const url = "{{ route('ratingsHoje')}}";
            $.ajax({
                url: url,
                success: function(data) {
                    $("#statstoday").html(data);
                }
            });
        });

        $("#dashboard").ready(function() {
            const url = "{{ route('countRatings')}}";
            $.ajax({
                url: url,
                success: function(data) {
                    $("#statscount").html(data);
                }
            });
        });

        $("#dashboard").ready(function() {
            const url = "{{ route('ratingsMes')}}";
            $.ajax({
                url: url,
                success: function(data) {
                    $("#statsmonth").html(data);
                }
            });
        });

        $("#dashboard").ready(function() {
            const url = "{{ route('ratingsAno')}}";
            $.ajax({
                url: url,
                success: function(data) {
                    $("#statsyear").html(data);
                }
            });
        });
    });
</script>
