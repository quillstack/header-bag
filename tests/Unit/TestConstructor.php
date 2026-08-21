<?php

declare(strict_types=1);

namespace Quillstack\HeaderBag\Tests\Unit;

use Quillstack\HeaderBag\Exceptions\InvalidHeaderArgumentException;
use Quillstack\HeaderBag\HeaderBag;
use Quillstack\UnitTests\AssertEqual;
use Quillstack\UnitTests\AssertExceptions;

class TestConstructor
{
    public function __construct(
        private AssertEqual $assertEqual,
        private AssertExceptions $assertExceptions
    ) {
        //
    }

    public function noHeadersAtAll()
    {
        $this->assertEqual->equal([], (new HeaderBag())->getHeaders());
    }

    public function aStringAndAListAreBothAccepted()
    {
        $bag = new HeaderBag([
            'Content-Type' => 'text/json',
            'Set-Cookie' => ['a=1', 'b=2'],
        ]);

        $this->assertEqual->equal([
            'Content-Type' => ['text/json'],
            'Set-Cookie' => ['a=1', 'b=2'],
        ], $bag->getHeaders());
    }

    public function aValueWhichIsNotAStringIsReported()
    {
        $this->assertExceptions->expect(InvalidHeaderArgumentException::class);

        new HeaderBag(['Content-Length' => 12]);
    }

    public function aListHoldingSomethingElseThanStringsIsReported()
    {
        $this->assertExceptions->expect(InvalidHeaderArgumentException::class);

        new HeaderBag(['Set-Cookie' => ['a=1', null]]);
    }
}
