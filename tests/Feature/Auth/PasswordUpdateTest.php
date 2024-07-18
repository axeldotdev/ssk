<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

test('password can be updated', function () {
    $user = User::factory()->withCurrentCompany()->create();

    $response = $this
        ->actingAs($user)
        ->from('/profile')
        ->put('/password', [
            'current_password' => 'W544AW&t',
            'password' => 'W544AW$t',
            'password_confirmation' => 'W544AW$t',
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/profile');

    $this->assertTrue(Hash::check('W544AW$t', $user->refresh()->password));
});

test('correct password must be provided to update password', function () {
    $user = User::factory()->withCurrentCompany()->create();

    $response = $this
        ->actingAs($user)
        ->from('/profile')
        ->put('/password', [
            'current_password' => 'W544AWt',
            'password' => 'W544AW&t',
            'password_confirmation' => 'W544AW&t',
        ]);

    $response
        ->assertSessionHasErrors('current_password')
        ->assertRedirect('/profile');
});
