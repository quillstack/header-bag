<?php

declare(strict_types=1);

namespace Quillstack\HeaderBag\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Quillstack\HeaderBag\Exceptions\MethodNotImplementedException;
use Quillstack\HeaderBag\HeaderBag;
use Quillstack\HeaderBag\Tests\Mocks\Stream;

class MethodsNotImplementedTest extends TestCase
{
    private HeaderBag $bag;

    public function setUp(): void
    {
        $this->bag = new HeaderBag([]);
    }

    public function testGetProtocolVersion()
    {
        $this->expectException(MethodNotImplementedException::class);

        $this->bag->getProtocolVersion();
    }

    public function testWithProtocolVersion()
    {
        $this->expectException(MethodNotImplementedException::class);

        $this->bag->withProtocolVersion('1.0');
    }

    public function testGetBody()
    {
        $this->expectException(MethodNotImplementedException::class);

        $this->bag->getBody();
    }

    public function testWithBody()
    {
        $this->expectException(MethodNotImplementedException::class);

        $this->bag->withBody(new Stream());
    }
}
