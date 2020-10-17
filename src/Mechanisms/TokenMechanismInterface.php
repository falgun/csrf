<?php

namespace Falgun\Csrf\Mechanisms;

interface TokenMechanismInterface
{

    public function generate(): string;
    public function equals(string $storedToken, string $inputToken):bool;
}
