<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Pruebas</title>
    <link rel="stylesheet" href="<?php echo e(asset('css/tabla.css')); ?>">
</head>
<body>
    <?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
         <?php $__env->slot('header', null, []); ?> 
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                <?php echo e(__('Pruebas')); ?>

            </h2>
         <?php $__env->endSlot(); ?>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Campo de filtro -->
                <div style="margin-bottom: 1rem;">
                    <input list="clientes-list" id="filter-cliente" placeholder="Elige un cliente" />
                    <datalist id="clientes-list">
                        <?php $__currentLoopData = $pruebas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prueba): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($prueba->cliente); ?>"></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                            <?php $__currentLoopData = $pruebas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prueba): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr id="row-<?php echo e($prueba->id); ?>" data-cliente="<?php echo e($prueba->cliente); ?>">
                                <td><?php echo e($prueba->id); ?></td>
                                <td>
                                    <input type="text" class="editable-input" id="cliente-<?php echo e($prueba->id); ?>" value="<?php echo e($prueba->cliente); ?>" />
                                </td>
                                <td>
                                    <input type="text" class="editable-input" id="punto-<?php echo e($prueba->id); ?>" value="<?php echo e($prueba->punto); ?>" />
                                </td>
                                <td>
                                    <input type="date" class="editable-input" id="dia-<?php echo e($prueba->id); ?>" value="<?php echo e($prueba->dia); ?>" />
                                </td>
                                <td>
                                    <input type="time" class="editable-input" id="hora-<?php echo e($prueba->id); ?>" value="<?php echo e($prueba->hora); ?>" />
                                </td>
                                <td>
                                    <input type="text" class="editable-input" id="resultado-<?php echo e($prueba->id); ?>" value="<?php echo e($prueba->resultado); ?>" />
                                </td>
                                <td>
                                    <button class="button_stylish" onclick="guardarCambios(<?php echo e($prueba->id); ?>)">Guardar</button>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            
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
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
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
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
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
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
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
</html><?php /**PATH C:\Laravel\app_señal\resources\views/pruebas.blade.php ENDPATH**/ ?>