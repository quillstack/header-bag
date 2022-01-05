<?php

declare(strict_types=1);

namespace Quillstack\HeaderBag\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Quillstack\HeaderBag\HeaderBag;
use Quillstack\HeaderBag\Tests\Mocks\SimpleHeaders;

class WithoutHeaderTest extends TestCase
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
        $bag = $this->bag->withoutHeader(self::NEW_HEADER, 'test');

        $this->assertCount(SimpleHeaders::HEADERS_NUM, $this->bag->getHeaders());
        $this->assertCount(SimpleHeaders::HEADERS_NUM, $bag->getHeaders());

        $this->assertFalse($this->bag->hasHeader(self::NEW_HEADER));
        $this->assertFalse($bag->hasHeader(self::NEW_HEADER));

        $this->assertEquals('', $this->bag->getHeaderLine(self::NEW_HEADER));
        $this->assertEquals('', $bag->getHeaderLine(self::NEW_HEADER));
    }

    public function testWithExistingHeader()
    {
        $bag = $this->bag->withoutHeader(self::EXISTING_HEADER);

        $this->assertCount(SimpleHeaders::HEADERS_NUM, $this->bag->getHeaders());
        $this->assertCount(SimpleHeaders::HEADERS_NUM - 1, $bag->getHeaders());

        $this->assertTrue($this->bag->hasHeader(self::EXISTING_HEADER));
        $this->assertFalse($bag->hasHeader(self::EXISTING_HEADER));

        $this->assertEquals('/abc', $this->bag->getHeaderLine(self::EXISTING_HEADER));
        $this->assertEquals('', $bag->getHeaderLine(self::EXISTING_HEADER));
    }

    public function testWithExistingUpperCaseHeader()
    {
        $bag = $this->bag->withoutHeader(self::UPPER_CASE_HEADER);

        $this->assertCount(SimpleHeaders::HEADERS_NUM, $this->bag->getHeaders());
        $this->assertCount(SimpleHeaders::HEADERS_NUM - 1, $bag->getHeaders());

        $this->assertTrue($this->bag->hasHeader(self::UPPER_CASE_HEADER));
        $this->assertFalse($bag->hasHeader(self::UPPER_CASE_HEADER));

        $this->assertEquals('case', $this->bag->getHeaderLine(self::UPPER_CASE_HEADER));
        $this->assertEquals('', $bag->getHeaderLine(self::UPPER_CASE_HEADER));
    }

    public function testWithExistingUpperCaseInLowerCaseHeader()
    {
        $bag = $this->bag->withoutHeader(self::UPPER_CASE_IN_LOWER_CASE_HEADER);

        $this->assertCount(SimpleHeaders::HEADERS_NUM, $this->bag->getHeaders());
        $this->assertCount(SimpleHeaders::HEADERS_NUM - 1, $bag->getHeaders());

        $this->assertTrue($this->bag->hasHeader(self::UPPER_CASE_IN_LOWER_CASE_HEADER));
        $this->assertFalse($bag->hasHeader(self::UPPER_CASE_IN_LOWER_CASE_HEADER));

        $this->assertEquals('case', $this->bag->getHeaderLine(self::UPPER_CASE_IN_LOWER_CASE_HEADER));
        $this->assertEquals('', $bag->getHeaderLine(self::UPPER_CASE_IN_LOWER_CASE_HEADER));
    }
}
