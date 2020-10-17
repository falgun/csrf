<?php

namespace Falgun\Csrf\Storage;

interface TokenStorageInterface
{

    public function has(string $key): bool;

    public function get(string $key): string;

    public function set(string $key, string $token): void;

    public function remove(string $key): void;
}
