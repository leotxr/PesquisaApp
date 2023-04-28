<div>
    <div>
        <label tabindex="0" class="btn btn-outline  m-1">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>
        </label>
        <ul tabindex="0"
            class="dropdown-content menu p-2 shadow bg-base-100 rounded-box w-52 absolute inline-block">

            <li>

                <button type="button" wire:click="setPositivo">Positivo</button>

            </li>

            <li>

                <button type="button" wire:click="setNegativo"
                    >Negativo</button>

            </li>


            <li>

                <button type="button" wire:click="setSugestao"
                   >Sugestão</button>

            </li>
        </ul>
    </div>
</div>
