<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pruebas</title>
    <link rel="stylesheet" href="{{ asset('css/tabla.css') }}">
</head>
<body>
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Pruebas') }}
            </h2>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Campo de filtro -->
                <div style="margin-bottom: 1rem;">
                    <input list="clientes-list" id="filter-cliente" placeholder="Elige un cliente" />
                    <datalist id="clientes-list">
                        @foreach ($pruebas as $prueba)
                            <option value="{{ $prueba->cliente }}"></option>
                        @endforeach
                    </datalist>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Cliente</th>
                                <th>Punto</th>
                                <th>Día</th>
                                <th>Hora</th>
                                <th>Resultado</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pruebas as $prueba)
                            <tr id="row-{{ $prueba->id }}" data-cliente="{{ $prueba->cliente }}">
                                <td>{{ $prueba->id }}</td>
                                <td>
                                    <input type="text" class="editable-input" id="cliente-{{ $prueba->id }}" value="{{ $prueba->cliente }}" />
                                </td>
                                <td>
                                    <input type="text" class="editable-input" id="punto-{{ $prueba->id }}" value="{{ $prueba->punto }}" />
                                </td>
                                <td>
                                    <input type="date" class="editable-input" id="dia-{{ $prueba->id }}" value="{{ $prueba->dia }}" />
                                </td>
                                <td>
                                    <input type="time" class="editable-input" id="hora-{{ $prueba->id }}" value="{{ $prueba->hora }}" />
                                </td>
                                <td>
                                    <input type="text" class="editable-input" id="resultado-{{ $prueba->id }}" value="{{ $prueba->resultado }}" />
                                </td>
                                <td>
                                    <button class="button_stylish" onclick="guardarCambios({{ $prueba->id }})">Guardar</button>
                                </td>
                            </tr>
                            @endforeach
                            {{-- Fila adicional para nuevos registros --}}
                            <tr>
                                <td>---</td>
                                <td><input type="text" name="cliente" placeholder="Nuevo cliente" class="nuevo"></td>
                                <td><input type="text" name="punto" placeholder="Punto de prueba" class="nuevo"></td>
                                <td><input type="date" name="dia" class="nuevo"></td>
                                <td><input type="time" name="hora" class="nuevo"></td>
                                <td><input type="text" name="resultado" placeholder="Resultado" class="nuevo"></td>
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
            const punto = row.querySelector(`#punto-${id}`).value;
            const dia = row.querySelector(`#dia-${id}`).value;
            const hora = row.querySelector(`#hora-${id}`).value;
            const resultado = row.querySelector(`#resultado-${id}`).value;

            fetch(`/guardar_prueba/${id}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({ cliente, punto, dia, hora, resultado }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Registro actualizado con éxito.');
                } else {
                    alert('Ha habido un error.');
                }
            })
            .catch(error => console.error('Error:', error));
        }

        // Añadir un nuevo registro
        document.querySelector('.guardar-nuevo').addEventListener('click', function () {
            const row = this.closest('tr');
            const cliente = row.querySelector('input[name="cliente"]').value;
            const punto = row.querySelector('input[name="punto"]').value;
            const dia = row.querySelector('input[name="dia"]').value;
            const hora = row.querySelector('input[name="hora"]').value;
            const resultado = row.querySelector('input[name="resultado"]').value;

            fetch('/registrar_prueba', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({ cliente, punto, dia, hora, resultado }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Nuevo registro añadido con éxito.');
                    location.reload();  // Recarga la página para reflejar el nuevo registro
                } else {
                    alert('Error al añadir el registro.');
                }
            })
            .catch(error => console.error('Error:', error));
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