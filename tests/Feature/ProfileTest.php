<?php

use App\Models\Company;
use App\Models\User;

test('profile page is displayed', function () {
    $user = User::factory()->withCurrentCompany()->create();

    $response = $this
        ->actingAs($user)
        ->get('/profile');

    $response->assertOk();
});

test('profile information can be updated', function () {
    $user = User::factory()->withCurrentCompany()->create();

    $response = $this
        ->actingAs($user)
        ->patch('/profile', [
            'firstname' => 'John',
            'lastname' => 'Doe',
            'email' => 'axelcharpentier0@icloud.com',
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/profile');

    $user->refresh();

    $this->assertSame('John', $user->firstname);
    $this->assertSame('axelcharpentier0@icloud.com', $user->email);
});

test('email verification status is unchanged when the email address is unchanged', function () {
    $user = User::factory()->withCurrentCompany()->create([
        'email' => 'axelcharpentier0@icloud.com',
    ]);

    $response = $this
        ->actingAs($user)
        ->patch('/profile', [
            'firstname' => 'John',
            'lastname' => 'Doe',
            'email' => $user->email,
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/profile');

    $this->assertNotNull($user->refresh()->verified_at);
});

test('user can delete their account', function () {
    $company = Company::factory()->create();
    $user = User::factory()->create();
    $user->companies()->attach($company);

    $response = $this
        ->actingAs($user, 'web')
        ->delete('/profile', [
            'password' => 'W544AW&t',
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/login');

    $this->assertGuest();
    $this->assertNull($user->fresh());
});

test('correct password must be provided to delete account', function () {
    $user = User::factory()->withCurrentCompany()->create();

    $response = $this
        ->actingAs($user)
        ->from('/profile')
        ->delete('/profile', [
            'password' => 'wrong-password',
        ]);

    $response
        ->assertSessionHasErrors('password')
        ->assertRedirect('/profile');

    $this->assertNotNull($user->fresh());
});
