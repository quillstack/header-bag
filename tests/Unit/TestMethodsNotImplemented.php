<?php

declare(strict_types=1);

namespace Quillstack\HeaderBag\Tests\Unit;

use Quillstack\HeaderBag\Exceptions\MethodNotImplementedException;
use Quillstack\HeaderBag\HeaderBag;
use Quillstack\HeaderBag\Tests\Mocks\Stream;
use Quillstack\UnitTests\AssertExceptions;

class TestMethodsNotImplemented
{
    public function __construct(private HeaderBag $bag, private AssertExceptions $assertExceptions)
    {
        //
    }

    public function getProtocolVersion()
    {
        $this->assertExceptions->expect(MethodNotImplementedException::class);

        $this->bag->getProtocolVersion();
    }

    public function withProtocolVersion()
    {
        $this->assertExceptions->expect(MethodNotImplementedException::class);

        $this->bag->withProtocolVersion('1.0');
    }

    public function getBody()
    {
        $this->assertExceptions->expect(MethodNotImplementedException::class);

        $this->bag->getBody();
    }

    public function withBody()
    {
        $this->assertExceptions->expect(MethodNotImplementedException::class);

        $this->bag->withBody(new Stream());
    }
}
