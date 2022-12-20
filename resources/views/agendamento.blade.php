<x-guest-layout>
    <form name="formAgendamento" id="formAgendamento" method="POST" action="{{route('sendDados')}}">
        @csrf
        <div class="hero h-screen bg-base-200">
            <div class="hero-content text-center">
                <div class="max-w-md">
                    @foreach($requisicoes as $requisicao)
                    <h1 class="text-3xl font-bold">Olá {{$requisicao->PACIENTE}}</h1>
                    <input class="text-3xl font-bold" id="data_req" name="data_req" value="{{$requisicao->DATA}}" style="display: none;"></input>
                    <input class="text-3xl font-bold" id="id" name="id" value="{{$requisicao->REQUISICAOID}}" style="display: none;"></input>
                    <input class="text-3xl font-bold" id="paciente_id" name="paciente_id" value="{{$requisicao->PACIENTEID}}" style="display: none;"></input>
                    <input class="text-3xl font-bold" id="paciente_name" name="paciente_name" value="{{$requisicao->PACIENTE}}" style="display: none;"></input>
                    <p class="py-10 text-xl">Qual a forma de agendamento do seu exame?</p>

                    <div class="agendamento flex justify-center gap-10 " required>
                        <div class="form-check form-check-inline">
                            <label class="radio-inline">
                                <input type="radio" name="radio_agendamento" id="ipresencial" value="Presencial" onclick="altColor()" class="radio" style="opacity: 0; position: absolute;" />
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" id="presencial" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-20 h-20">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                </svg>
                                Presencial
                            </label>
                        </div>

                        <div class="form-check form-check-inline">
                            <label class="radio-inline">
                                <input type="radio" name="radio_agendamento" id="itelefone" value="Telefone" onclick="altColor()" class="radio" style="opacity: 0; position: absolute;" />
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" id="telefone" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-20 h-20">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                                </svg>
                                Telefone
                            </label>
                        </div>

                        <div class="form-check form-check-inline">
                            <label class="radio-inline">
                                <input type="radio" name="radio_agendamento" id="iwhatsapp" value="WhatsApp" onclick="altColor()" class="radio" style="opacity: 0; position: absolute;" />
                                <svg version="1.0" xmlns="http://www.w3.org/2000/svg" id="whatsapp" fill="currentColor" stroke="currentColor" stroke-width="1.5" viewBox="0 0 768.000000 768.000000" preserveAspectRatio="xMidYMid meet" class="w-20 h-20">

                                    <g transform="translate(0.000000,768.000000) scale(0.100000,-0.100000)">
                                        <path d="M3655 6714 c-186 -19 -256 -28 -360 -49 -552 -110 -1058 -381 -1460 -780 -775 -770 -1046 -1897 -705 -2935 45 -137 130 -337 192 -450 l45 -82 -202 -736 c-111 -405 -198 -738 -194 -740 4 -2 345 85 757 194 l750 196 114 -55 c570 -281 1228 -362 1851 -231 1149 243 2041 1172 2236 2329 121 716 -36 1457 -434 2057 -371 557 -940 982 -1565 1166 -272 81 -478 112 -770 116 -118 2 -233 2 -255 0z m475 -495 c907 -105 1678 -728 1978 -1601 113 -327 153 -726 107 -1073 -67 -510 -294 -979 -655 -1349 -317 -326 -691 -544 -1116 -652 -224 -56 -331 -69 -594 -69 -249 0 -344 10 -555 60 -227 54 -466 151 -676 276 l-67 40 -447 -116 c-246 -64 -448 -115 -451 -113 -2 2 50 199 116 438 l119 435 -59 95 c-255 414 -372 851 -357 1340 19 627 267 1185 723 1631 513 500 1220 741 1934 658z" />
                                        <path d="M2764 5163 c-64 -24 -94 -47 -172 -136 -123 -142 -181 -292 -189 -488 -8 -190 20 -314 117 -514 108 -224 358 -553 610 -805 349 -348 721 -567 1200 -706 313 -91 625 -21 831 185 36 36 73 83 82 103 31 66 58 191 60 274 2 69 -1 85 -18 103 -10 12 -112 67 -225 122 -336 164 -401 192 -456 197 -58 5 -36 24 -193 -173 -128 -162 -162 -195 -200 -195 -42 0 -237 85 -355 154 -249 148 -463 354 -643 621 -60 89 -85 144 -79 170 3 12 44 67 91 121 95 111 147 199 147 249 0 20 -47 148 -117 317 -127 308 -159 373 -190 394 -13 9 -65 16 -136 19 -95 5 -122 3 -165 -12z" />
                                    </g>
                                </svg>
                                WhatsApp
                            </label>
                        </div>
                    </div>
                    <button type="submit" id="btn-show-agenda" href="" onclick="alterarDiv(this)" class="my-10 btn btn-primary btn-wide ">Avançar</button>
                </div>
                @endforeach
            </div>
        </div>

    </form>
</x-guest-layout>
