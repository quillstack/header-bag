<?php

declare(strict_types=1);

namespace Quillstack\HeaderBag\Tests\Unit;

use Quillstack\HeaderBag\HeaderBag;
use Quillstack\HeaderBag\Tests\Mocks\SimpleHeaders;
use Quillstack\UnitTests\AssertEqual;
use Quillstack\UnitTests\Types\AssertArray;
use Quillstack\UnitTests\Types\AssertBoolean;

class TestGetHeaders
{
    private HeaderBag $bag;
    private array $headers;

    public function __construct(
        private AssertArray $assertArray,
        private AssertBoolean $assertBoolean,
        private AssertEqual $assertEqual
    ) {
        $this->headers = (new SimpleHeaders())->headers;
        $this->bag = new HeaderBag($this->headers);
    }

    public function type()
    {
        $this->assertArray->isArray($this->bag->getHeaders());
    }

    /**
     * The fixture names one header twice, in two cases, and both stand for the same header.
     */
    public function namesDifferingOnlyInCaseAreOneHeader()
    {
        $this->assertArray->count(SimpleHeaders::HEADERS_NUM_WITH_DUPLICATES, $this->headers);
        $this->assertArray->count(SimpleHeaders::HEADERS_NUM, $this->bag->getHeaders());
    }

    /**
     * PSR-7 keeps a list of values per header, so every value is wrapped in an array.
     */
    public function everyHeaderHoldsAListOfValues()
    {
        foreach ($this->bag->getHeaders() as $name => $values) {
            $this->assertArray->isArray($values);
            $this->assertEqual->equal($values, $this->bag->getHeader($name));
        }
    }

    public function theHeaderKeepsTheNameItWasFirstSeenUnder()
    {
        $headers = $this->bag->getHeaders();

        $this->assertArray->hasKey(':path', $headers);
        $this->assertArray->doesntHaveKey(':PATH', $headers);

        // The later value replaces the earlier one, under the name seen first.
        $this->assertEqual->equal(['/abc'], $headers[':path']);
    }

    public function everyNameOfTheFixtureIsFound()
    {
        foreach (array_keys($this->headers) as $name) {
            $this->assertBoolean->isTrue($this->bag->hasHeader($name));
        }
    }
}
