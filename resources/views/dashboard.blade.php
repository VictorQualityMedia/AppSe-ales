<html>
    <head>
        <title>Editar Presupuesto</title>
        <link rel="stylesheet" href="{{ asset('css/zona_administrador.css') }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>
    <body>
            <x-app-layout>
                <x-slot name="header">
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                        {{ __('Principal') }}
                    </h2>
                </x-slot>

                <div class="py-12">
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 text-gray-900 dark:text-gray-100">
                                {{ __("¡Bienvenido de nuevo!") }}
                            </div>
                        </div>
                    </div>
                </div>
            </x-app-layout>
    </body>
</html>