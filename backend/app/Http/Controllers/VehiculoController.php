<?php

namespace App\Http\Controllers;

use App\Models\Vehiculo;
use Illuminate\Http\Request;

/**
 * @OA\Info(
 *     title="API vehiculos acme",
 *     version="1.0.0",
 *     description="API para vehiculos de transporte acme"
 * )
 */


class VehiculoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     *
     * @OA\Get(
     *     path="/api/vehiculos",
     *     summary="Get a list of all vehicles",
     *     @OA\Response(response="200", description="List of all vehicles")
     * )
     */
    public function index()
    {
        $vehiculos = Vehiculo::all();
        return response()->json($vehiculos);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Vehiculo  $vehiculo
     *
     * @OA\Get(
     *     path="/api/vehiculos/{vehiculo}",
     *     summary="Get the details of a specific vehicle by ID",
     *     @OA\Parameter(
     *         name="vehiculo",
     *         in="path",
     *         description="ID of the vehicle to retrieve",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(response="200", description="Details of the specified vehicle")
     * )
     */
    public function show(Vehiculo $vehiculo)
    {
        return response()->json($vehiculo);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request
     *
     * @OA\Post(
     *     path="/api/vehiculos",
     *     summary="Crear un nuevo vehículo",
     * @OA\RequestBody(
     *     description="Datos requeridos para crear un nuevo vehículo.",
     *     required=true,
     *     @OA\JsonContent(
     *         @OA\Property(property="placa", type="string", maxLength=50, example="ABC-123"),
     *         @OA\Property(property="motor", type="string", maxLength=256, nullable=true, example="12345"),
     *         @OA\Property(property="marca", type="string", maxLength=50, example="Toyota"),
     *         @OA\Property(property="color", type="string", maxLength=50, nullable=true, example="Rojo"),
     *         @OA\Property(property="tipo_vehiculo", type="integer", example=1),
     *         @OA\Property(property="id_conductor", type="integer", example=1),
     *     ),
     * ),
     *     @OA\Response(
     *         response=201,
     *         description="Vehículo creado exitosamente"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error de validación",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The given data was invalid."),
     *             @OA\Property(property="errors", type="object", example={"placa": {"The placa field is required."}})
     *         )
     *     ),
     *     security={{ "BearerAuth":{} }}
     * )
     */
    public function store(Request  $request)
    {
        $tipo = $request->input('type');
        $marca = $request->input('brand');

        $vehiculos = Vehiculo::query();

        if ($tipo) {
            $$vehiculos->where('tipo_vehiculo', 'like', '%' . $tipo . '%');
        }

        if ($marca) {
            $vehiculos->where('marca', 'like', '%' . $marca . '%');
        }

        $vehiculos = $vehiculos->get();

        return response()->json($vehiculos, 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Vehiculo  $vehiculo
     *
     * @OA\Put(
     *     path="/api/vehiculos/{vehiculo}",
     *     summary="Update an existing vehicle",
     *     @OA\Parameter(
     *         name="vehiculo",
     *         in="path",
     *         description="ID of the vehicle to update",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *         @OA\Property(property="placa", type="string", maxLength=50, example="ABC-123"),
     *         @OA\Property(property="motor", type="string", maxLength=256, nullable=true, example="12345"),
     *         @OA\Property(property="marca", type="string", maxLength=50, example="Toyota"),
     *         @OA\Property(property="color", type="string", maxLength=50, nullable=true, example="Rojo"),
     *         @OA\Property(property="tipo_vehiculo", type="integer", example=1),
     *         @OA\Property(property="id_conductor", type="integer", example=1),
     *     ),
     *     ),
     *     @OA\Response(response="200", description="The updated vehicle")
     * )
     */
    public function update(Request $request, Vehiculo $vehiculo)
    {
        $validatedData = $request->validate([
            'placa' => 'required|max:50|unique:vehiculos,placa,' . $vehiculo->id,
            'motor' => 'nullable|max:256',
            'marca' => 'required|max:50',
            'color' => 'nullable|max:50',
            'tipo_vehiculo' => 'required|integer',
            'id_conductor' => 'required|exists:conductores,id',
        ]);

        $vehiculo->update($validatedData);

        return response()->json($vehiculo);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Vehiculo  $vehiculo
     *
     * @OA\Delete(
     *     path="/api/vehiculos/{vehiculo}",
     *     summary="Delete a vehicle",
     *     description="Delete an existing vehicle from the database",
     *     operationId="eliminarVehiculo",
     *     tags={"Vehicles"},
     *     @OA\Parameter(
     *         name="vehiculo",
     *         in="path",
     *         description="ID of the vehicle to delete",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Vehicle deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="The specified vehicle was not found"
     *     ),
     *     security={
     *         {"bearerAuth": {}}
     *     }
     * )
     */

    public function destroy(Vehiculo $vehiculo)
    {
        $vehiculo->delete();

        return response()->json(null, 204);
    }
    /**
     * Get vehicles by tipo and/or marca.
     *
     * @OA\Get(
     *     path="/api/vehiculos/filtrar",
     *     summary="Obtener vehículos por tipo y/o marca.",
     *     description="Obtiene vehículos filtrándolos por su tipo y/o marca.",
     *     operationId="getByTypeOrBrand",
     *     tags={"Vehiculos"},
     *     @OA\Parameter(
     *         name="tipo",
     *         description="Tipo del vehículo por el que filtrar.",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="marca",
     *         description="Marca del vehículo por la que filtrar.",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Solicitud incorrecta"
     *     )
     * )
     * @param \Illuminate\Http\Request $request
     */
    public function  getByTypeOrBrand(Request $request)
    {

        $tipo = $request->input('type');
        $marca = $request->input('brand');

        $vehiculos = Vehiculo::query();

        if ($tipo) {
            $$vehiculos->where('tipo_vehiculo', 'like', '%' . $tipo . '%');
        }

        if ($marca) {
            $vehiculos->where('marca', 'like', '%' . $marca . '%');
        }

        $vehiculos = $vehiculos->get();

        return response()->json($vehiculos);
    }

    /**
     * Get vehicles by driver id.
     *
     * @OA\Get(
     *      path="/api/vehiculos/driver",
     *      operationId="getByDriverId",
     *      tags={"Vehiculos"},
     *      summary="Obtener vehículos por ID de conductor",
     *      description="Obtiene los vehículos asociados al ID de conductor proporcionado.",
     *      @OA\Parameter(
     *          name="id",
     *          in="query",
     *          description="ID del conductor",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="OK"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Conductor no encontrado",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="No se encontró el conductor con el ID proporcionado."
     *              )
     *          )
     *      )
     * )
     */
    public function getByDriverId(Request $request)
    {
        $id_conductor = $request->input('id');
        $vehiculos = Vehiculo::where('conductor_id', $id_conductor)
            ->get();
        return response()->json($vehiculos);
    }
}
