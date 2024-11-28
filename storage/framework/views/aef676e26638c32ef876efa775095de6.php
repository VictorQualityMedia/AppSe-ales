<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Señales</title>
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
                    <?php echo e(__('Señales')); ?>

                </h2>
             <?php $__env->endSlot(); ?>
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="py-12">
                    <!-- Campo de filtro -->
                    <div style="margin-bottom: 1rem;">
                        <input list="clientes-list" id="filter-cliente" placeholder="Elige un cliente" />
                        <datalist id="clientes-list">
                            <?php $__currentLoopData = $senales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $senal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($senal->cliente); ?>"></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                                <?php $__currentLoopData = $senales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $senal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr id="row-<?php echo e($senal->id); ?>" data-cliente="<?php echo e($senal->cliente); ?>">
                                    <td><?php echo e($senal->id); ?></td>
                                    <td>
                                        <input type="text" class="editable-input" id="cliente-<?php echo e($senal->id); ?>" value="<?php echo e($senal->cliente); ?>" />
                                    </td>
                                    <td>
                                        <input type="number" class="editable-input" id="envios-<?php echo e($senal->id); ?>" value="<?php echo e($senal->envios); ?>" />
                                    </td>
                                    <td>
                                        <input type="date" class="editable-input" id="dia-<?php echo e($senal->id); ?>" value="<?php echo e($senal->dia); ?>" />
                                    </td>
                                    <td>
                                        <input type="time" class="editable-input" id="hora-<?php echo e($senal->id); ?>" value="<?php echo e($senal->hora); ?>" />
                                    </td>
                                    <td>
                                        <button class="button_stylish" onclick="guardarCambios(<?php echo e($senal->id); ?>)">Guardar</button>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                
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
            const envios = row.querySelector(`#envios-${id}`).value;
            const dia = row.querySelector(`#dia-${id}`).value;
            const hora = row.querySelector(`#hora-${id}`).value;

            console.log({ cliente, envios, dia, hora });

            fetch(`/guardar_senal/${id}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
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
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
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
</html><?php /**PATH C:\Laravel\app_señal\resources\views/senales.blade.php ENDPATH**/ ?>