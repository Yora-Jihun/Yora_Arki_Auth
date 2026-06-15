<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\AuthService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Auth\AuthenticationException;
use Tests\TestCase;

class AuthServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_with_correct_credentials_succeeds(): void
    {
        $user = User::factory()->create([
            'email' => 'user@example.com',
            'password' => 'password',
        ]);

        $result = app(AuthService::class)->login([
            'email' => $user->email,
            'password' => 'password',
        ], false);

        $this->assertInstanceOf(User::class, $result);
        $this->assertTrue($result->is($user));
    }

    public function test_login_throws_exception_for_nonexistent_account(): void
    {
        $this->expectException(AuthenticationException::class);
        $this->expectExceptionMessage('This account is not found');

        app(AuthService::class)->login([
            'email' => 'nonexistent@example.com',
            'password' => 'password',
        ], false);
    }

    public function test_login_throws_exception_for_incorrect_password(): void
    {
        $user = User::factory()->create([
            'email' => 'user@example.com',
            'password' => 'password',
        ]);

        $this->expectException(AuthenticationException::class);
        $this->expectExceptionMessage('Incorrect Password');

        app(AuthService::class)->login([
            'email' => $user->email,
            'password' => 'wrong-password',
        ], false);
    }

    public function test_login_without_remember_forgets_existing_remember_cookie(): void
    {
        $user = User::factory()->create([
            'email' => 'user@example.com',
            'password' => 'password',
        ]);

        Cookie::queue(Cookie::make(Auth::getRecallerName(), 'stale', 525600));

        app(AuthService::class)->login([
            'email' => $user->email,
            'password' => 'password',
        ], false);

        $queuedCookie = $this->queuedCookie(Auth::getRecallerName());

        $this->assertNotNull($queuedCookie);
        $this->assertTrue($queuedCookie->isCleared());
        $this->assertAuthenticatedAs($user);
    }

    public function test_login_with_remember_queues_remember_cookie(): void
    {
        $user = User::factory()->create([
            'email' => 'user@example.com',
            'password' => 'password',
        ]);

        app(AuthService::class)->login([
            'email' => $user->email,
            'password' => 'password',
        ], true);

        $queuedCookie = $this->queuedCookie(Auth::getRecallerName());

        $this->assertNotNull($queuedCookie);
        $this->assertFalse($queuedCookie->isCleared());
        $this->assertAuthenticatedAs($user);
    }

    private function queuedCookie(string $name): ?\Symfony\Component\HttpFoundation\Cookie
    {
        return collect(Cookie::getQueuedCookies())
            ->first(fn (\Symfony\Component\HttpFoundation\Cookie $cookie): bool => $cookie->getName() === $name);
    }
}
