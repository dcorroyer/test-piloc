<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePropertyRequest;
use App\Models\Property;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $properties = Property::all();

        return response()->json($properties);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StorePropertyRequest $request
     * @return JsonResponse
     */
    public function store(StorePropertyRequest $request): JsonResponse
    {
        $property = Property::create($request->all());

        return response()->json($property, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param Property $property
     * @return JsonResponse
     */
    public function show(Property $property): JsonResponse
    {
        $data = $property->toArray();
        $data['address'] = $property->address()->get()->toArray();

        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StorePropertyRequest $request
     * @param Property $property
     * @return JsonResponse
     */
    public function update(StorePropertyRequest $request, Property $property): JsonResponse
    {
        $property->update($request->all());

        return response()->json($property);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Property $property
     * @return JsonResponse
     */
    public function destroy(Property $property): JsonResponse
    {
        $property->delete();

        return response()->json($property);
    }
}
