<?php

declare(strict_types=1);

namespace Quillstack\HeaderBag\Tests\Unit;

use Quillstack\HeaderBag\Exceptions\InvalidHeaderArgumentException;
use Quillstack\HeaderBag\HeaderBag;
use Quillstack\HeaderBag\Tests\DataProviders\InvalidHeaderValueDataProvider;
use Quillstack\HeaderBag\Tests\Mocks\SimpleHeaders;
use Quillstack\UnitTests\AssertEqual;
use Quillstack\UnitTests\AssertExceptions;
use Quillstack\UnitTests\Attributes\ProvidesDataFrom;
use Quillstack\UnitTests\Types\AssertArray;
use Quillstack\UnitTests\Types\AssertBoolean;

class TestWithHeader
{
    private const NEW_HEADER = 'new-header';
    private const EXISTING_HEADER = ':path';

    private HeaderBag $bag;

    public function __construct(
        private AssertArray $assertArray,
        private AssertBoolean $assertBoolean,
        private AssertEqual $assertEqual,
        private AssertExceptions $assertExceptions
    ) {
        $headers = (new SimpleHeaders())->headers;
        $this->bag = new HeaderBag($headers);
    }

    public function withNewHeader()
    {
        $bag = $this->bag->withHeader(self::NEW_HEADER, 'test');

        $this->assertArray->count(SimpleHeaders::HEADERS_NUM, $this->bag->getHeaders());
        $this->assertArray->count(SimpleHeaders::HEADERS_NUM + 1, $bag->getHeaders());

        $this->assertBoolean->isFalse($this->bag->hasHeader(self::NEW_HEADER));
        $this->assertBoolean->isTrue($bag->hasHeader(self::NEW_HEADER));

        $this->assertEqual->equal('', $this->bag->getHeaderLine(self::NEW_HEADER));
        $this->assertEqual->equal('test', $bag->getHeaderLine(self::NEW_HEADER));
    }

    public function withExistingHeader()
    {
        $bag = $this->bag->withHeader(self::EXISTING_HEADER, '/test');

        $this->assertArray->count(SimpleHeaders::HEADERS_NUM, $this->bag->getHeaders());
        $this->assertArray->count(SimpleHeaders::HEADERS_NUM, $bag->getHeaders());

        $this->assertBoolean->isTrue($this->bag->hasHeader(self::EXISTING_HEADER));
        $this->assertBoolean->isTrue($bag->hasHeader(self::EXISTING_HEADER));

        $this->assertEqual->equal('/abc', $this->bag->getHeaderLine(self::EXISTING_HEADER));
        $this->assertEqual->equal('/test', $bag->getHeaderLine(self::EXISTING_HEADER));
    }

    #[ProvidesDataFrom(InvalidHeaderValueDataProvider::class)]
    public function nameIsNotStringException()
    {
        $this->assertExceptions->expect(InvalidHeaderArgumentException::class);

        $this->bag->withHeader(['test'], '/test');
    }

    #[ProvidesDataFrom(InvalidHeaderValueDataProvider::class)]
    public function valueIsNotStringNorArrayException($invalidValue)
    {
        $this->assertExceptions->expect(InvalidHeaderArgumentException::class);

        $this->bag->withHeader(self::EXISTING_HEADER, $invalidValue);
    }
}
