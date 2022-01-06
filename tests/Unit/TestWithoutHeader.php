<?php

declare(strict_types=1);

namespace Quillstack\HeaderBag\Tests\Unit;

use Quillstack\HeaderBag\HeaderBag;
use Quillstack\HeaderBag\Tests\Mocks\SimpleHeaders;
use Quillstack\UnitTests\AssertEqual;
use Quillstack\UnitTests\Types\AssertArray;
use Quillstack\UnitTests\Types\AssertBoolean;

class TestWithoutHeader
{
    private const NEW_HEADER = 'new-header';
    private const EXISTING_HEADER = ':path';
    private const UPPER_CASE_HEADER = 'UPPER';
    private const UPPER_CASE_IN_LOWER_CASE_HEADER = 'upper';

    private HeaderBag $bag;

    public function __construct(
        private AssertArray $assertArray,
        private AssertBoolean $assertBoolean,
        private AssertEqual $assertEqual
    ) {
        $headers = (new SimpleHeaders())->headers;
        $this->bag = new HeaderBag($headers);
    }

    public function testWithNewHeader()
    {
        $bag = $this->bag->withoutHeader(self::NEW_HEADER, 'test');

        $this->assertArray->count(SimpleHeaders::HEADERS_NUM, $this->bag->getHeaders());
        $this->assertArray->count(SimpleHeaders::HEADERS_NUM, $bag->getHeaders());

        $this->assertBoolean->isFalse($this->bag->hasHeader(self::NEW_HEADER));
        $this->assertBoolean->isFalse($bag->hasHeader(self::NEW_HEADER));

        $this->assertEqual->equal('', $this->bag->getHeaderLine(self::NEW_HEADER));
        $this->assertEqual->equal('', $bag->getHeaderLine(self::NEW_HEADER));
    }

    public function testWithExistingHeader()
    {
        $bag = $this->bag->withoutHeader(self::EXISTING_HEADER);

        $this->assertArray->count(SimpleHeaders::HEADERS_NUM, $this->bag->getHeaders());
        $this->assertArray->count(SimpleHeaders::HEADERS_NUM - 1, $bag->getHeaders());

        $this->assertBoolean->isTrue($this->bag->hasHeader(self::EXISTING_HEADER));
        $this->assertBoolean->isFalse($bag->hasHeader(self::EXISTING_HEADER));

        $this->assertEqual->equal('/abc', $this->bag->getHeaderLine(self::EXISTING_HEADER));
        $this->assertEqual->equal('', $bag->getHeaderLine(self::EXISTING_HEADER));
    }

    public function testWithExistingUpperCaseHeader()
    {
        $bag = $this->bag->withoutHeader(self::UPPER_CASE_HEADER);

        $this->assertArray->count(SimpleHeaders::HEADERS_NUM, $this->bag->getHeaders());
        $this->assertArray->count(SimpleHeaders::HEADERS_NUM - 1, $bag->getHeaders());

        $this->assertBoolean->isTrue($this->bag->hasHeader(self::UPPER_CASE_HEADER));
        $this->assertBoolean->isFalse($bag->hasHeader(self::UPPER_CASE_HEADER));

        $this->assertEqual->equal('case', $this->bag->getHeaderLine(self::UPPER_CASE_HEADER));
        $this->assertEqual->equal('', $bag->getHeaderLine(self::UPPER_CASE_HEADER));
    }

    public function testWithExistingUpperCaseInLowerCaseHeader()
    {
        $bag = $this->bag->withoutHeader(self::UPPER_CASE_IN_LOWER_CASE_HEADER);

        $this->assertArray->count(SimpleHeaders::HEADERS_NUM, $this->bag->getHeaders());
        $this->assertArray->count(SimpleHeaders::HEADERS_NUM - 1, $bag->getHeaders());

        $this->assertBoolean->isTrue($this->bag->hasHeader(self::UPPER_CASE_IN_LOWER_CASE_HEADER));
        $this->assertBoolean->isFalse($bag->hasHeader(self::UPPER_CASE_IN_LOWER_CASE_HEADER));

        $this->assertEqual->equal('case', $this->bag->getHeaderLine(self::UPPER_CASE_IN_LOWER_CASE_HEADER));
        $this->assertEqual->equal('', $bag->getHeaderLine(self::UPPER_CASE_IN_LOWER_CASE_HEADER));
    }
}
