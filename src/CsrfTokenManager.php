<?php
declare(strict_types=1);

namespace Falgun\Csrf;

use Falgun\Csrf\Storage\SessionStorage;
use Falgun\Csrf\Mechanisms\BasicHashMechanism;
use Falgun\Csrf\Storage\TokenStorageInterface;
use Falgun\Csrf\Mechanisms\TokenMechanismInterface;

final class CsrfTokenManager
{

    private TokenStorageInterface $storage;
    private TokenMechanismInterface $mechanism;

    public function __construct(
        TokenStorageInterface $storage = null,
        TokenMechanismInterface $mechanism = null
    )
    {
        $this->storage = $storage ?? SessionStorage::dirtyResolve();
        $this->mechanism = $mechanism ?? new BasicHashMechanism();
    }

    public function getOrGenerate(string $key): CsrfToken
    {
        if ($this->storage->has($key)) {
            return CsrfToken::new($key, $this->storage->get($key));
        }

        // generatge new one
        $token = $this->mechanism->generate();

        $this->storage->set($key, $token);

        return CsrfToken::new($key, $token);
    }

    public function isValid(CsrfToken $csrfToken): bool
    {
        if ($this->storage->has($csrfToken->getKey()) === false) {
            return false;
        }

        $storedToken = $this->storage->get($csrfToken->getKey());

        return $this->mechanism->equals($storedToken, $csrfToken->getToken());
    }
}
