<?php
declare(strict_types=1);

namespace Falgun\Csrf\Tests;

use Falgun\Http\Session;
use PHPUnit\Framework\TestCase;
use Falgun\Csrf\Storage\SessionStorage;

final class StorageTest extends TestCase
{

    public function testSessionStorage()
    {
        $_SESSION = [];
        $storage = new SessionStorage(new Session);

        $this->assertFalse($storage->has('token'));

        $storage->set('token', 'abcd');

        $this->assertTrue($storage->has('token'));

        $this->assertSame('abcd', $storage->get('token'));

        $storage->remove('token');

        $this->assertFalse($storage->has('token'));
    }

    public function testDirtyResolve()
    {
        $storage = SessionStorage::dirtyResolve();

        $this->assertInstanceOf(SessionStorage::class, $storage);
    }
}
