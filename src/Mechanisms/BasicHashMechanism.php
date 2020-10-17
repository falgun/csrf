<?php
declare(strict_types=1);

namespace Falgun\Csrf\Mechanisms;

final class BasicHashMechanism implements TokenMechanismInterface
{

    private int $lengthInBytes;

    public function __construct(int $lengthInBytes = 32)
    {
        $this->lengthInBytes = $lengthInBytes;
    }

    public function generate(): string
    {
        $bytes = \random_bytes($this->lengthInBytes);

        return \rtrim(\strtr(\base64_encode($bytes), '+/', '-_'), '=');
    }

    public function equals(string $storedToken, string $inputToken): bool
    {
        return \hash_equals($storedToken, $inputToken);
    }
}
