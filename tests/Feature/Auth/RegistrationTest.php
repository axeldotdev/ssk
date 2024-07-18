<?php

test('registration screen can be rendered', function () {
    $response = $this->get('/register');

    $response->assertStatus(200);
});

test('new users can register', function () {
    $response = $this->post('/register', [
        'firstname' => 'John',
        'lastname' => 'Doe',
        'email' => 'axelcharpentier0@icloud.com',
        'password' => 'W544AW&t',
        'password_confirmation' => 'W544AW&t',
        'terms' => true,
    ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('dashboard', absolute: false));

    $this->assertAuthenticated();
});
