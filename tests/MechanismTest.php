<?php
declare(strict_types=1);

namespace Falgun\Csrf\Tests;

use PHPUnit\Framework\TestCase;
use Falgun\Csrf\Mechanisms\BasicHashMechanism;

final class MechanismTest extends TestCase
{

    public function testHashMechanism()
    {
        $hashMechanism = new BasicHashMechanism();
        
        $token = $hashMechanism->generate();
        
//        $this->assertTrue(strlen($token) >= 60, 'token size :'. strlen($token));
        $this->assertSame(43, strlen($token));
    }
}
