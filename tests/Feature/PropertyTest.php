<?php

namespace Tests\Feature;

use App\Models\Address;
use App\Models\Property;
use App\Models\User;
use Tests\TestCase;

class PropertyTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testGetPropertyList(): void
    {
        $user = User::find(1);

        $response = $this->actingAs($user, 'api')
            ->withSession(['banned' => false])
            ->get('http://localhost:8080/api/properties');

        $response->assertStatus(200);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testGetPropertyItem(): void
    {
        $user = User::find(1);

        $property = $user->properties()->first();

        $response = $this->actingAs($user, 'api')
            ->withSession(['banned' => false])
            ->get('http://localhost:8080/api/properties/' . $property->id);

        $response->assertStatus(200);
    }

//    /**
//     * A basic feature test example.
//     *
//     * @return void
//     */
//    public function testPostProperty(): void
//    {
//        $user = User::find(1);
//
//        $data = [
//            'wording' => 'ma super maison',
//            'surface' => 55,
//            'amount' => 555,
//            'status' => 'available',
//            'address' => [
//                'street' => '15 rue du Paradis',
//                'postal_code' => 75010,
//                'city' => "Paris"
//            ]
//        ];
//
//        $response = $this->actingAs($user, 'api')
//            ->withSession(['banned' => false])
//            ->post('http://localhost:8080/api/properties', (array)json_encode($data));
//
//        $response->assertStatus(200);
//        $content = json_decode($response->getContent(), true);
//        $this->deleteProperty($content);
//    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testPutProperty(): void
    {
        $user = User::find(1);

        $property = $user->properties()->first();

        $data = [
            'wording' => 'ma super maison',
            'surface' => 55,
            'amount' => 555,
            'status' => 'deleted',
            'address' => [
                'street' => '15 rue du Paradis',
                'postal_code' => 75010,
                'city' => "Paris"
            ]
        ];

        $response = $this->actingAs($user, 'api')
            ->withSession(['banned' => false])
            ->put('http://localhost:8080/api/properties/' . $property->id, (array)json_encode($data));

        $response->assertStatus(200);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testDeleteProperty(): void
    {
        $user = User::find(1);
        $propertyToDelete = $this->createProperty();

        $response = $this->actingAs($user, 'api')
            ->withSession(['banned' => false])
            ->delete('http://localhost:8080/api/properties/' . $propertyToDelete->id);

        $response->assertStatus(200);
    }

    public function createProperty(): Property
    {
        $user = User::find(1);

        $data = [
            'wording' => 'ma super maison',
            'surface' => 55,
            'amount' => 555,
            'status' => 'deleted',
            'address' => [
                'street' => '15 rue du Paradis',
                'postal_code' => 75010,
                'city' => "Paris"
            ]
        ];

        $property = new Property([
            'wording' => $data['wording'],
            'surface' => $data['surface'],
            'amount' => $data['amount'],
            'status' => $data['status'],
            'user_id' => $user->id,
        ]);

        $address = Address::where('street', $data['address']['street'])->first();

        if (!$address) {
            $address = new Address([
                'street' => $data['address']['street'],
                'postal_code' => $data['address']['postal_code'],
                'city' => $data['address']['city'],
            ]);

            $address->save();
        }

        $property->address_id = $address->id;
        $property->save();

        return $property;
    }

//    public function deleteProperty(array $property): bool
//    {
//        $propertyToDelete = Property::find($property['property']['id']);
//        $propertyToDelete->delete();
//
//        return true;
//    }
}
