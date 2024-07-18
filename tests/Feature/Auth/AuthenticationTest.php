<?php

use App\Models\User;

test('login screen can be rendered', function () {
    $response = $this->get('/login');

    $response
        ->assertSessionHasNoErrors()
        ->assertStatus(200);
});

test('users can authenticate using the login screen', function () {
    $user = User::factory()->withCurrentCompany()->create([
        'email' => 'axelcharpentier0@icloud.com',
    ]);

    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'W544AW&t',
    ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('dashboard', absolute: false));

    $this->assertAuthenticated();
});

test('users can not authenticate with invalid password', function () {
    $user = User::factory()->withCurrentCompany()->create();

    $this->post('/login', [
        'email' => $user->email,
        'password' => 'wrong-password',
    ]);

    $this->assertGuest();
});

test('users can logout', function () {
    $user = User::factory()->withCurrentCompany()->create();

    $response = $this->actingAs($user)->post('/logout');

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/');

    $this->assertGuest();
});
