<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testGetUserList(): void
    {
        $user = User::find(1);

        $response = $this->actingAs($user, 'api')
            ->withSession(['banned' => false])
            ->get('http://localhost:8080/api/users');

        $response->assertStatus(200);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testGetUserItem(): void
    {
        $user = User::find(1);

        $data = User::first();

        $response = $this->actingAs($user, 'api')
            ->withSession(['banned' => false])
            ->get('http://localhost:8080/api/users/' . $data->id);

        $response->assertStatus(200);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testPostUser(): void
    {
        $user = User::find(1);

        $data = [
            'lastname' => 'corroyer',
            'firstname' => 'dylan',
            'email' => 'dylan+111@gmail.com',
            'password' => 'password',
        ];

        $response = $this->actingAs($user, 'api')
            ->withSession(['banned' => false])
            ->post('http://localhost:8080/api/users', $data);

        $response->assertStatus(201);
        $content = json_decode($response->getContent(), true);

        $this->deleteUser($content);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testPutUser(): void
    {
        $user = User::find(1);

        $userToDelete = $this->createUser()->id;

        $data = [
            'lastname' => 'corroyer',
            'firstname' => 'dylan',
            'email' => fake()->unique()->safeEmail(),
            'password' => 'password',
        ];

        $response = $this->actingAs($user, 'api')
            ->withSession(['banned' => false])
            ->put('http://localhost:8080/api/users/' . $userToDelete, $data);

        $response->assertStatus(200);
        $content = json_decode($response->getContent(), true);
        $this->deleteUser($content);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testDeleteUser(): void
    {
        $user = User::find(1);
        $userToDelete = $this->createUser()->id;

        $response = $this->actingAs($user, 'api')
            ->withSession(['banned' => false])
            ->delete('http://localhost:8080/api/users/' . $userToDelete);

        $response->assertStatus(200);
    }

    public function createUser(): User
    {
        $data = [
            'lastname' => 'corroyer',
            'firstname' => 'dylan',
            'email' => fake()->unique()->safeEmail(),
            'password' => 'password',
        ];

        $user = new User([
            'lastname' => $data['lastname'],
            'firstname' => $data['firstname'],
            'email' => $data['email'],
            'password' => $data['password'],
        ]);

        $user->save();

        return $user;
    }

    public function deleteUser(array $user): bool
    {
        $userToDelete = User::find($user['property']['id']);
        $userToDelete->delete();

        return true;
    }
}
