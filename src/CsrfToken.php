<?php
declare(strict_types=1);

namespace Falgun\Csrf;

final class CsrfToken
{

    private string $key;
    private string $token;

    private function __construct(string $key, string $token)
    {
        $this->key = $key;
        $this->token = $token;
    }

    public static function new(string $key, string $token): CsrfToken
    {
        return new static($key, $token);
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function getToken(): string
    {
        return $this->token;
    }
}
