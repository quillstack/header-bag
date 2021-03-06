<?php

declare(strict_types=1);

namespace QuillStack\Http\HeaderBag;

use PHPUnit\Framework\TestCase;
use QuillStack\Http\HeaderBag\Exceptions\InvalidHeaderArgumentException;
use QuillStack\Mocks\HeaderBag\SimpleHeaders;

final class WithAddedHeaderTest extends TestCase
{
    private const NEW_HEADER = 'new-header';

    private const EXISTING_HEADER = ':path';

    /**
     * @var HeaderBag
     */
    private HeaderBag $bag;

    protected function setUp(): void
    {
        $headers = (new SimpleHeaders())->headers;
        $this->bag = new HeaderBag($headers);
    }

    public function testWithNewHeader()
    {
        $bag = $this->bag->withAddedHeader(self::NEW_HEADER, 'test');

        $this->assertCount(16, $this->bag->getHeaders());
        $this->assertCount(17, $bag->getHeaders());

        $this->assertFalse($this->bag->hasHeader(self::NEW_HEADER));
        $this->assertTrue($bag->hasHeader(self::NEW_HEADER));

        $this->assertEquals('', $this->bag->getHeaderLine(self::NEW_HEADER));
        $this->assertEquals('test', $bag->getHeaderLine(self::NEW_HEADER));
    }

    public function testWithExistingHeader()
    {
        $bag = $this->bag->withAddedHeader(self::EXISTING_HEADER, '/test');

        $this->assertCount(16, $this->bag->getHeaders());
        $this->assertCount(16, $bag->getHeaders());

        $this->assertTrue($this->bag->hasHeader(self::EXISTING_HEADER));
        $this->assertTrue($bag->hasHeader(self::EXISTING_HEADER));

        $this->assertEquals('/', $this->bag->getHeaderLine(self::EXISTING_HEADER));
        $this->assertEquals('/,/test', $bag->getHeaderLine(self::EXISTING_HEADER));
    }

    public function testWithExistingHeaderAddArray()
    {
        $bag = $this->bag->withAddedHeader(self::EXISTING_HEADER, ['/test', '/login']);

        $this->assertCount(16, $this->bag->getHeaders());
        $this->assertCount(16, $bag->getHeaders());

        $this->assertTrue($this->bag->hasHeader(self::EXISTING_HEADER));
        $this->assertTrue($bag->hasHeader(self::EXISTING_HEADER));

        $this->assertEquals('/', $this->bag->getHeaderLine(self::EXISTING_HEADER));
        $this->assertEquals('/,/test,/login', $bag->getHeaderLine(self::EXISTING_HEADER));
    }

    public function testNameIsNotStringException()
    {
        $this->expectException(InvalidHeaderArgumentException::class);

        $this->bag->withAddedHeader(['test'], '/test');
    }

    public function provideInvalidValues()
    {
        return [
            [3],
            [false],
            [true],
            [new \stdClass()],
            [-1.23],
            [null],
        ];
    }

    /**
     * @param $invalidValue
     * @dataProvider provideInvalidValues
     */
    public function testValueIsNotStringNorArrayException($invalidValue)
    {
        $this->expectException(InvalidHeaderArgumentException::class);

        $this->bag->withAddedHeader(self::EXISTING_HEADER, $invalidValue);
    }
}
