<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePropertyRequest;
use App\Models\Address;
use App\Models\Property;
use Illuminate\Http\JsonResponse;
use Spatie\QueryBuilder\QueryBuilder;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $user = auth()->user();

        foreach ($user->roles as $role) {
            if ($role->name === "admin") {
                $properties = QueryBuilder::for(Property::class)
                    ->allowedFilters('status', 'address.city', 'address.postal_code')
                    ->where('user_id', $user->id)
                    ->paginate(10);

                return response()->json([
                    'properties' => $properties
                ]);
            }
        }

        $properties = QueryBuilder::for(Property::class)
            ->allowedFilters('status', 'address.city', 'address.postal_code')
            ->where('user_id', $user->id)
            ->whereNot(function ($query) {
                $query->where('status', '=', 'deleted');
            })
            ->paginate(10);

        return response()->json([
            'properties' => $properties
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StorePropertyRequest $request
     * @return JsonResponse
     */
    public function store(StorePropertyRequest $request): JsonResponse
    {
        $user = auth()->user();

        $property = new Property([
            'wording' => $request['wording'],
            'surface' => $request['surface'],
            'amount' => $request['amount'],
            'status' => $request['status'],
            'user_id' => $user->id,
        ]);

        dd($property);

        $address = Address::where('street', $request['address.0.street'])->first();

        if (!$address) {
            $address = new Address([
                'street' => $request['address.0.street'],
                'postal_code' => $request['address.0.postal_code'],
                'city' => $request['address.0.city'],
            ]);

            $address->save();
        }

        $property->address_id = $address->id;
        $property->save();

        return response()->json([
            'message' => "Property saved successfully!",
            'property' => $property
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $user = auth()->user();

        $property = Property::with(['user', 'address'])
            ->where('user_id', $user->id)
            ->find($id)
        ;

        if (!$property) {
            return response()->json([
                'message' => 'Property not found',
            ], 404);
        }

        $data = $property->makeHidden('user_id', 'address_id')->toArray();
        $data['address'] = $property->address()->get()->toArray();
        $data['user'] = $property->user()->get()->toArray();

        return response()->json([
            'properties' => $data
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StorePropertyRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(StorePropertyRequest $request, int $id): JsonResponse
    {
        $user = auth()->user();

        $property = Property::with(['user', 'address'])
            ->where('user_id', $user->id)
            ->find($id)
        ;

        if (!$property) {
            return response()->json([
                'message' => 'Property not found',
            ], 404);
        }

        $property->update($request->all());

        $address = Address::where('street', $request['address.0.street'])->first();

        if (!$address) {
            $address = new Address([
                'street' => $request['address.0.street'],
                'postal_code' => $request['address.0.postal_code'],
                'city' => $request['address.0.city'],
            ]);

            $address->save();
        }

        $property->address_id = $address->id;
        $property->save();

        return response()->json([
            'message' => "Property updated successfully!",
            'property' => $property
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $user = auth()->user();
        $property = Property::where('user_id', $user->id)->find($id);

        if (!$property) {
            return response()->json([
                'message' => 'Property not found',
            ], 404);
        }

        $property->status = 'deleted';

        return response()->json([
            'message' => "Property deleted successfully!",
            'property' => $property
        ]);
    }
}
