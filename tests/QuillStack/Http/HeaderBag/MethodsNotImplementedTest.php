<?php

declare(strict_types=1);

namespace QuillStack\Http\HeaderBag;

use PHPUnit\Framework\TestCase;
use QuillStack\Http\HeaderBag\Exceptions\MethodNotImplementedException;
use QuillStack\Mocks\HeaderBag\Stream;

final class MethodsNotImplementedTest extends TestCase
{
    /**
     * @var HeaderBag
     */
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
