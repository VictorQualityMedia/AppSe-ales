<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Señales</title>
        <link rel="stylesheet" href="{{ asset('css/tabla.css') }}">
    </head>
    <body>
        <x-app-layout>
            <x-slot name="header">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Señales') }}
                </h2>
            </x-slot>
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="py-12">
                    <!-- Campo de filtro -->
                    <div style="margin-bottom: 1rem;">
                        <input list="clientes-list" id="filter-cliente" placeholder="Elige un cliente" />
                        <datalist id="clientes-list">
                            @foreach ($senales as $senal)
                                <option value="{{ $senal->cliente }}"></option>
                            @endforeach
                        </datalist>
                    </div>
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <table>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Cliente</th>
                                    <th>Envíos</th>
                                    <th>Día</th>
                                    <th>Hora</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($senales as $senal)
                                <tr id="row-{{ $senal->id }}" data-cliente="{{ $senal->cliente }}">
                                    <td>{{ $senal->id }}</td>
                                    <td>
                                        <input type="text" class="editable-input" id="cliente-{{ $senal->id }}" value="{{ $senal->cliente }}" />
                                    </td>
                                    <td>
                                        <input type="number" class="editable-input" id="envios-{{ $senal->id }}" value="{{ $senal->envios }}" />
                                    </td>
                                    <td>
                                        <input type="date" class="editable-input" id="dia-{{ $senal->id }}" value="{{ $senal->dia }}" />
                                    </td>
                                    <td>
                                        <input type="time" class="editable-input" id="hora-{{ $senal->id }}" value="{{ $senal->hora }}" />
                                    </td>
                                    <td>
                                        <button class="button_stylish" onclick="guardarCambios({{ $senal->id }})">Guardar</button>
                                    </td>
                                </tr>
                                @endforeach
                                {{-- Fila adicional para nuevos registros --}}
                                <tr>
                                    <td>---</td>
                                    <td><input type="text" name="cliente" placeholder="Nuevo cliente" class="nuevo" list="clientes-list"></td>
                                    <td><input type="number" name="envios" placeholder="Cantidad de envíos" class="nuevo"></td>
                                    <td><input type="date" name="dia" class="nuevo"></td>
                                    <td><input type="time" name="hora" class="nuevo"></td>
                                    <td>
                                        <button class="button_stylish guardar-nuevo">Añadir</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </x-app-layout>
        <script>
        // Guardar cambios en registros existentes
        function guardarCambios(id) {
            const row = document.querySelector(`#row-${id}`);
            const cliente = row.querySelector(`#cliente-${id}`).value;
            const envios = row.querySelector(`#envios-${id}`).value;
            const dia = row.querySelector(`#dia-${id}`).value;
            const hora = row.querySelector(`#hora-${id}`).value;

            console.log({ cliente, envios, dia, hora });

            fetch(`/guardar_senal/${id}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({ cliente, envios, dia, hora }),
            })
                .then((response) => response.json())
                .then((data) => {
                    if (data.success) {
                        alert('Registro actualizado con éxito.');
                    } else {
                        alert('Ha habido un error.');
                    }
                })
                .catch((error) => {
                    console.error('Error:', error);
                });
                location.reload();
        }

        // Añadir un nuevo registro
        document.querySelector('.guardar-nuevo').addEventListener('click', function () {
            const row = this.closest('tr');
            const cliente = row.querySelector('input[name="cliente"]').value;
            const envios = row.querySelector('input[name="envios"]').value;
            const dia = row.querySelector('input[name="dia"]').value;
            const hora = row.querySelector('input[name="hora"]').value;

            console.log({ cliente, envios, dia, hora });

            fetch('/registrar_senal', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({ cliente, envios, dia, hora }),
            })
                .then((response) => response.json())
                .then((data) => {
                    if (data.success) {
                        alert('Nuevo registro añadido con éxito.');
                        location.reload(); // Recargar la página para mostrar el nuevo registro
                    } else {
                        location.reload();
                    }
                })
                .catch((error) => {
                    console.error('Error:', error);
                    location.reload();
                });
        });

        // Filtro de cliente
        const clienteInput = document.getElementById('filter-cliente');
        clienteInput.addEventListener('input', () => {
            const cliente = clienteInput.value.toLowerCase();
            const rows = document.querySelectorAll('tbody tr');

            rows.forEach(row => {
                const rowCliente = row.getAttribute('data-cliente').toLowerCase();
                if (rowCliente.includes(cliente) || cliente === '') {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
    </body>
</html>