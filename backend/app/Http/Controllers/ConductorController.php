<?php

namespace App\Http\Controllers;

use App\Models\Conductor;
use Illuminate\Http\Request;

class ConductorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $conductores = Conductor::all();
        return response()->json($conductores);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Conductor  $conductor
     */
    public function show(Conductor $conductor)
    {
        return response()->json($conductor);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'es_propietario' => 'nullable|boolean',
            'nro_cedula' => 'required|unique:conductores|max:20',
            'primer_nombre' => 'required|max:50',
            'segundo_nombre' => 'nullable|max:50',
            'apellidos' => 'required|max:100',
            'telefono' => 'required|max:20',
            'direccion' => 'required|max:150',
            'ciudad' => 'required|max:50',
        ]);

        $conductor = Conductor::create($validatedData);

        return response()->json($conductor, 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Conductor  $conductor
     */
    public function update(Request $request, Conductor $conductor)
    {
        $validatedData = $request->validate([
            'es_propietario' => 'nullable|boolean',
            'nro_cedula' => 'required|max:20|unique:conductores,nro_cedula,' . $conductor->id,
            'primer_nombre' => 'required|max:50',
            'segundo_nombre' => 'nullable|max:50',
            'apellidos' => 'required|max:100',
            'telefono' => 'required|max:20',
            'direccion' => 'required|max:150',
            'ciudad' => 'required|max:50',
        ]);

        $conductor->update($validatedData);

        return response()->json($conductor);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Conductor  $conductor
     */
    public function destroy(Conductor $conductor)
    {
        $conductor->delete();

        return response()->json(null, 204);
    }
}
