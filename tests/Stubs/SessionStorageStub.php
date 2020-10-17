<?php
declare(strict_types=1);

namespace Falgun\Csrf\Tests\Stubs;

use Falgun\Csrf\Storage\TokenStorageInterface;

final class SessionStorageStub implements TokenStorageInterface
{

    private array $session;

    public function __construct(array $session = [])
    {
        $this->session = $session;
    }

    public function get(string $key): string
    {
        return $this->session[$key];
    }

    public function has(string $key): bool
    {
        return isset($this->session[$key]);
    }

    public function remove(string $key): void
    {
        unset($this->session[$key]);
    }

    public function set(string $key, string $token): void
    {
        $this->session[$key] = $token;
    }
}
