<x-guest-layout>
    <div class="hero min-h-screen bg-base-200">
        <div class="hero-content text-center">
            <div class="max-w-md">
                <h1 class="text-5xl font-bold">Ocorreu um erro :(</h1>
                <p class="py-6">O sistema ainda está em fase de testes.</p>
<?php
                echo ini_set('display_errors', 1);
                echo error_reporting(E_ALL);
?>
                <button class="btn btn-warning">Tentar Novamente</button>
            </div>
        </div>
    </div>
</x-guest-layout>
