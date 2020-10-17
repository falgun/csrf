<?php
declare(strict_types=1);

namespace Falgun\Csrf\Storage;

use Falgun\Http\Session;

final class SessionStorage implements TokenStorageInterface
{

    private Session $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public static function dirtyResolve(): self
    {
        $session = new Session;

        return new static($session);
    }

    public function get(string $key): string
    {
        return $this->session->get($key);
    }

    public function has(string $key): bool
    {
        return $this->session->has($key);
    }

    public function remove(string $key): void
    {
        $this->session->remove($key);
    }

    public function set(string $key, string $token): void
    {
        $this->session->set($key, $token);
    }
}
