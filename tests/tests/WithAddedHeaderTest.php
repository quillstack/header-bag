<?php

declare(strict_types=1);

namespace Quillstack\Tests\HeaderBag;

use PHPUnit\Framework\TestCase;
use Quillstack\HeaderBag\Exceptions\InvalidHeaderArgumentException;
use Quillstack\HeaderBag\HeaderBag;
use Quillstack\Mocks\HeaderBag\SimpleHeaders;

class WithAddedHeaderTest extends TestCase
{
    private const NEW_HEADER = 'new-header';
    private const EXISTING_HEADER = ':path';
    private const UPPER_CASE_HEADER = 'UPPER';
    private const UPPER_CASE_IN_LOWER_CASE_HEADER = 'upper';

    private HeaderBag $bag;

    protected function setUp(): void
    {
        $headers = (new SimpleHeaders())->headers;
        $this->bag = new HeaderBag($headers);
    }

    public function testWithNewHeader()
    {
        $bag = $this->bag->withAddedHeader(self::NEW_HEADER, 'test');

        $this->assertCount(SimpleHeaders::HEADERS_NUM, $this->bag->getHeaders());
        $this->assertCount(SimpleHeaders::HEADERS_NUM + 1, $bag->getHeaders());

        $this->assertFalse($this->bag->hasHeader(self::NEW_HEADER));
        $this->assertTrue($bag->hasHeader(self::NEW_HEADER));

        $this->assertEquals('', $this->bag->getHeaderLine(self::NEW_HEADER));
        $this->assertEquals('test', $bag->getHeaderLine(self::NEW_HEADER));
    }

    public function testWithExistingHeader()
    {
        $bag = $this->bag->withAddedHeader(self::EXISTING_HEADER, '/test');
        $this->assertCount(SimpleHeaders::HEADERS_NUM, $this->bag->getHeaders());
        $this->assertCount(SimpleHeaders::HEADERS_NUM, $bag->getHeaders());

        $this->assertTrue($this->bag->hasHeader(self::EXISTING_HEADER));
        $this->assertTrue($bag->hasHeader(self::EXISTING_HEADER));

        $this->assertEquals('/abc', $this->bag->getHeaderLine(self::EXISTING_HEADER));
        $this->assertEquals('/abc,/test', $bag->getHeaderLine(self::EXISTING_HEADER));
    }

    public function testWithExistingHeaderAddArray()
    {
        $bag = $this->bag->withAddedHeader(self::EXISTING_HEADER, ['/test', '/login']);

        $this->assertCount(SimpleHeaders::HEADERS_NUM, $this->bag->getHeaders());
        $this->assertCount(SimpleHeaders::HEADERS_NUM, $bag->getHeaders());

        $this->assertTrue($this->bag->hasHeader(self::EXISTING_HEADER));
        $this->assertTrue($bag->hasHeader(self::EXISTING_HEADER));

        $this->assertEquals('/abc', $this->bag->getHeaderLine(self::EXISTING_HEADER));
        $this->assertEquals('/abc,/test,/login', $bag->getHeaderLine(self::EXISTING_HEADER));
    }

    public function testWithExistingUpperCaseHeaderAddArray()
    {
        $bag = $this->bag->withAddedHeader(self::UPPER_CASE_HEADER, ['upper', 'lower']);

        $this->assertCount(SimpleHeaders::HEADERS_NUM, $this->bag->getHeaders());
        $this->assertCount(SimpleHeaders::HEADERS_NUM, $bag->getHeaders());

        $this->assertTrue($this->bag->hasHeader(self::UPPER_CASE_HEADER));
        $this->assertTrue($bag->hasHeader(self::UPPER_CASE_HEADER));

        $this->assertEquals('case', $this->bag->getHeaderLine(self::UPPER_CASE_HEADER));
        $this->assertEquals('case,upper,lower', $bag->getHeaderLine(self::UPPER_CASE_HEADER));
    }

    public function testWithExistingUpperCaseInLowerCaseHeaderAddArray()
    {
        $bag = $this->bag->withAddedHeader(self::UPPER_CASE_IN_LOWER_CASE_HEADER, ['a', 'b']);

        $this->assertCount(SimpleHeaders::HEADERS_NUM, $this->bag->getHeaders());
        $this->assertCount(SimpleHeaders::HEADERS_NUM, $bag->getHeaders());

        $this->assertTrue($this->bag->hasHeader(self::UPPER_CASE_IN_LOWER_CASE_HEADER));
        $this->assertTrue($bag->hasHeader(self::UPPER_CASE_IN_LOWER_CASE_HEADER));

        $this->assertEquals('case', $this->bag->getHeaderLine(self::UPPER_CASE_IN_LOWER_CASE_HEADER));
        $this->assertEquals('case,a,b', $bag->getHeaderLine(self::UPPER_CASE_IN_LOWER_CASE_HEADER));
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
