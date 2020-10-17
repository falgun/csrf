<?php
declare(strict_types=1);

namespace Falgun\Csrf\Tests;

use Falgun\Csrf\CsrfToken;
use PHPUnit\Framework\TestCase;
use Falgun\Csrf\CsrfTokenManager;
use Falgun\Csrf\Tests\Stubs\SessionStorageStub;
use Falgun\Csrf\Mechanisms\BasicHashMechanism;
use Falgun\Csrf\Storage\TokenStorageInterface;
use Falgun\Csrf\Mechanisms\TokenMechanismInterface;

final class TokenManagerTest extends TestCase
{

    public function testTokenGeneration()
    {
        $storage = new SessionStorageStub();
        
        $mechanism = $this->createMock(TokenMechanismInterface::class);
        $mechanism->method('generate')->willReturn('abcdxyz');

        $manager = new CsrfTokenManager($storage, $mechanism);

        $token = $manager->getOrGenerate('_token');

        $this->assertSame('_token', $token->getKey());
        $this->assertSame('abcdxyz', $token->getToken());
        
        $this->assertSame('abcdxyz', $storage->get('_token'));
    }

    public function testTokenGet()
    {
        $storage = new SessionStorageStub();
        $storage->set('_token', 'get_abcdxyz');

        $mechanism = $this->createMock(TokenMechanismInterface::class);

        $manager = new CsrfTokenManager($storage, $mechanism);

        $token = $manager->getOrGenerate('_token');

        $this->assertSame('_token', $token->getKey());
        $this->assertSame('get_abcdxyz', $token->getToken());
    }

    public function testValidTokenValidation()
    {
        
        $storage = new SessionStorageStub();
        $storage->set('_token', 'w6nAeYtf-0xvPZtVqxiEZ19MxaM5Ora3iEZyWs_xl3E');

        $mechanism = new BasicHashMechanism();

        $manager = new CsrfTokenManager($storage, $mechanism);

        $isValid = $manager->isValid(CsrfToken::new('_token', 'w6nAeYtf-0xvPZtVqxiEZ19MxaM5Ora3iEZyWs_xl3E'));

        $this->assertTrue($isValid);
    }

    public function testInvalidTokenValidation()
    {
       $storage = new SessionStorageStub();

        $mechanism = $this->createMock(TokenMechanismInterface::class);

        $manager = new CsrfTokenManager($storage, $mechanism);

        $isValid = $manager->isValid(CsrfToken::new('_token', 'w6nAeYtf-0xvPZtVqxiEZ19MxaM5Ora3iEZyWs_xl3E'));

        $this->assertFalse($isValid);
    }
}
