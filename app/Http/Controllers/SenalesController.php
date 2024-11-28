<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Senal; 
use Illuminate\Http\Response;

class SenalesController extends Controller
{
    public function senales() {

        // Obtén todos los registros de la tabla senales
        $senales = DB::table('senales')->get(); // Selecciona todos los campos automáticamente

        // Pasar todos los presupuestos a la vista
        return view('senales', [
        'senales' => $senales // Pasamos toda la colección a la vista
        ]);
    }

    // Método para registrar una nueva señal
    public function registrar_senal(Request $request): Response
    {
        if ($request->isMethod('POST')) {
            $data = json_decode($request->getContent(), true);

            // Validar los datos
            if (!isset($data['cliente'], $data['envios'], $data['dia'], $data['hora'])) {
                return $this->json(['error' => 'Datos incompletos'], Response::HTTP_BAD_REQUEST);
            }

            // Crear una nueva señal
            $senal = new Senal();
            $senal->cliente = $data['cliente'];
            $senal->envios = $data['envios'];
            $senal->dia = new \DateTime($data['dia']);
            $senal->hora = new \DateTime($data['hora']);

            // Guardar el modelo directamente con Eloquent
            $senal->save();

            return $this->json(['success' => 'Señal registrada correctamente']);
        }

        return $this->json(['error' => 'Método no permitido'], Response::HTTP_METHOD_NOT_ALLOWED);
    }

    public function guardar_senal(Request $request, int $id): Response
    {
        if ($request->isMethod('POST')) {
            $data = json_decode($request->getContent(), true);

            // Buscar la señal existente
            $senal = Senal::find($id); // Usa Eloquent para encontrar el registro por ID

            if (!$senal) {
                return response()->json(['error' => 'Señal no encontrada'], Response::HTTP_NOT_FOUND);
            }

            // Modificar los datos existentes
            if (isset($data['cliente'])) {
                $senal->cliente = $data['cliente'];
            }
            if (isset($data['envios'])) {
                $senal->envios = $data['envios'];
            }
            if (isset($data['dia'])) {
                $senal->dia = $data['dia'];
            }
            if (isset($data['hora'])) {
                $senal->hora = $data['hora'];
            }

            // Guardar los cambios en la base de datos
            $senal->save();

            return response()->json(['success' => 'Señal modificada correctamente'], Response::HTTP_OK);
        }

        return response()->json(['error' => 'Método no permitido'], Response::HTTP_METHOD_NOT_ALLOWED);
    }
}
