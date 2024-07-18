<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User;
use Mockery;
use Tests\TestCase;

class SocialstreamRegistrationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return array<int, array<int, string>>
     */
    public static function socialiteProvidersDataProvider(): array
    {
        return [
            ['google'],
            ['microsoft'],
        ];
    }

    /**
     * @dataProvider socialiteProvidersDataProvider
     */
    public function test_users_get_redirected_correctly(string $provider): void
    {
        config()->set("services.{$provider}", [
            'client_id' => 'client-id',
            'client_secret' => 'client-secret',
            'redirect' => "http://localhost/oauth/{$provider}/callback",
        ]);

        $response = $this->get("/oauth/{$provider}");
        $response->assertRedirectContains($provider);
    }

    /**
     * @dataProvider socialiteProvidersDataProvider
     */
    public function test_users_can_register_using_socialite_providers(string $socialiteProvider)
    {
        $user = (new User())
            ->map([
                'id' => 'abcdefgh',
                'nickname' => 'Jane',
                'name' => 'Jane Doe',
                'email' => 'janedoe@example.com',
                'avatar' => null,
                'avatar_original' => null,
            ])
            ->setToken('user-token')
            ->setRefreshToken('refresh-token')
            ->setExpiresIn(3600);

        $provider = Mockery::mock('Laravel\\Socialite\\Two\\' . $socialiteProvider . 'Provider');
        $provider->shouldReceive('user')->once()->andReturn($user);

        Socialite::shouldReceive('driver')->once()->with($socialiteProvider)->andReturn($provider);

        Session::put('socialstream.previous_url', route('register'));

        $response = $this->get("/oauth/{$socialiteProvider}/callback");

        $this->assertAuthenticated();
        $response->assertRedirect(route('dashboard', absolute: false));
    }
}
