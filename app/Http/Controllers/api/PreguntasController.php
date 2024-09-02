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

    // Realizar la consulta usando el departamento encontrado
    $datos = \DB::table($tema)->where('idDepartamento', $departamento->id)->get();

    $pregunta = Tablas::where('detalle', $tema)->get();

    return response()->json(['datos' => $datos, 'pregunta' => $pregunta]);
}

public function obtenerRespuestasIncorrectas(Request $request)
{
    $departamentoNombre = $request->input('departamento');
    $tema = $request->input('tema');
    $respuestaCorrecta = $request->input('respuesta_correcta');

    // Reemplazar la letra 'Ñ' con la representación adecuada para la consulta
    $departamentoNombre = str_replace('Ñ', '?', $departamentoNombre);

    $departamento = Departamento::where('detalle', $departamentoNombre)->first();

    if (!$departamento) {
        return response()->json(['error' => 'Departamento no encontrado'], 404);
    }

    if (!\Schema::hasTable($tema)) {
        return response()->json(['error' => 'Tema no válido'], 400);
    }

    // Obtener 10 respuestas incorrectas al azar
    $respuestasIncorrectas = \DB::table($tema)
        ->where('idDepartamento', '!=', $departamento->id)
        ->where('detalle', '!=', $respuestaCorrecta)
        ->inRandomOrder()
        ->limit(10)
        ->get();

    // Filtrar respuestas para obtener solo las únicas y seleccionar 3
    $respuestasUnicas = $respuestasIncorrectas->unique('detalle')->take(3);

    return response()->json(['respuestas_incorrectas' => $respuestasUnicas]);
}
}
