<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Prueba; 
use Illuminate\Http\Response;

class PruebasController extends Controller
{
    // Método para mostrar los registros
    public function pruebas()
    {
        // Obtener todos los registros de la tabla pruebas
        $pruebas = Prueba::all();

        // Pasar los datos a la vista
        return view('pruebas', [
            'pruebas' => $pruebas
        ]);
    }

    // Método para registrar una nueva prueba
    public function registrar_prueba(Request $request): Response
    {
        if ($request->isMethod('POST')) {
            $data = json_decode($request->getContent(), true);

            // Validar los datos
            if (!isset($data['cliente'], $data['punto'], $data['dia'], $data['hora'], $data['resultado'])) {
                return response()->json(['error' => 'Datos incompletos'], Response::HTTP_BAD_REQUEST);
            }

            // Crear una nueva prueba
            $prueba = new Prueba();
            $prueba->cliente = $data['cliente'];
            $prueba->punto = $data['punto'];
            $prueba->dia = $data['dia'];
            $prueba->hora = $data['hora'];
            $prueba->resultado = $data['resultado'];

            // Guardar en la base de datos
            $prueba->save();

            return response()->json(['success' => 'Prueba registrada correctamente']);
        }

        return response()->json(['error' => 'Método no permitido'], Response::HTTP_METHOD_NOT_ALLOWED);
    }

    // Método para guardar o modificar una prueba existente
    public function guardar_prueba(Request $request, int $id): Response
    {
        if ($request->isMethod('POST')) {
            $data = json_decode($request->getContent(), true);

            // Buscar la prueba existente
            $prueba = Prueba::find($id);

            if (!$prueba) {
                return response()->json(['error' => 'Prueba no encontrada'], Response::HTTP_NOT_FOUND);
            }

            // Modificar los datos existentes
            if (isset($data['cliente'])) {
                $prueba->cliente = $data['cliente'];
            }
            if (isset($data['punto'])) {
                $prueba->punto = $data['punto'];
            }
            if (isset($data['dia'])) {
                $prueba->dia = $data['dia'];
            }
            if (isset($data['hora'])) {
                $prueba->hora = $data['hora'];
            }
            if (isset($data['resultado'])) {
                $prueba->resultado = $data['resultado'];
            }

            // Guardar los cambios en la base de datos
            $prueba->save();

            return response()->json(['success' => 'Prueba modificada correctamente'], Response::HTTP_OK);
        }

        return response()->json(['error' => 'Método no permitido'], Response::HTTP_METHOD_NOT_ALLOWED);
    }
}