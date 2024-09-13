<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Departamento;
use App\Models\Tablas;


class PreguntasController extends Controller
{
    public function obtenerTema(Request $request)
    {
        $departamentoNombre = $request->input('departamento');
        $tema = $request->input('tema');
    
        // Reemplazar la letra 'Ñ' con la representación adecuada para la consulta
        $departamentoNombre = str_replace('Ñ', '?', $departamentoNombre);
    
        $departamento = Departamento::where('detalle', $departamentoNombre)->first();
    
        if (!$departamento) {
            return response()->json(['error' => 'Departamento no encontrado'], 404);
        }
    
        if (!\Schema::hasTable($tema)) {
            return response()->json(['error' => 'Tema no válido'], 400);
        }
    
        // Obtener la respuesta correcta del tema para el departamento
        $respuestaCorrecta = \DB::table($tema)
            ->where('idDepartamento', $departamento->id)
            ->first();
    
        if (!$respuestaCorrecta) {
            return response()->json(['error' => 'No se encontró la respuesta correcta'], 404);
        }
    
        // Llamar a la función obtenerRespuestasIncorrectas para obtener las respuestas incorrectas
        $respuestasIncorrectas = $this->obtenerRespuestasIncorrectas($departamentoNombre, $tema, $respuestaCorrecta->detalle);
    
        // Obtener la pregunta del tema
        $pregunta = Tablas::where('detalle', $tema)->get();
    
        // Devolver todo junto en la respuesta
        return response()->json([
            'pregunta' => $pregunta,
            'respuesta_correcta' => $respuestaCorrecta,
            'respuestas_incorrectas' => $respuestasIncorrectas
        ]);
    }
    
    public function obtenerRespuestasIncorrectas($departamentoNombre, $tema, $respuestaCorrecta)
    {
        $departamento = Departamento::where('detalle', $departamentoNombre)->first();
    
        if (!$departamento) {
            return response()->json(['error' => 'Departamento no encontrado'], 404);
        }
    
        if (!\Schema::hasTable($tema)) {
            return response()->json(['error' => 'Tema no válido'], 400);
        }
    
        // Obtener respuestas incorrectas, excluyendo la correcta
        $respuestasIncorrectas = \DB::table($tema)
            ->where('idDepartamento', '!=', $departamento->id)
            ->where('detalle', '!=', $respuestaCorrecta)
            ->inRandomOrder()
            ->limit(10) // Obtener hasta 10 respuestas incorrectas
            ->get();
    
        // Filtrar respuestas para obtener solo las únicas y seleccionar 3
        $respuestasUnicas = $respuestasIncorrectas->unique('detalle')->take(3);
    
        return $respuestasUnicas;
    }
    
}
