<?php

declare(strict_types=1);

namespace Quillstack\HeaderBag\Tests\Unit;

use Quillstack\HeaderBag\HeaderBag;
use Quillstack\HeaderBag\Tests\Mocks\SimpleHeaders;
use Quillstack\UnitTests\Types\AssertArray;
use Quillstack\UnitTests\Types\AssertBoolean;

class TestGetHeaders
{
    private HeaderBag $bag;
    private array $headers;

    public function __construct(private AssertArray $assertArray, private AssertBoolean $assertBoolean)
    {
        $this->headers = (new SimpleHeaders())->headers;
        $this->bag = new HeaderBag($this->headers);
    }

    public function type()
    {
        $this->assertArray->isArray($this->bag->getHeaders());
    }

    public function count()
    {
        $this->assertArray->count(SimpleHeaders::HEADERS_NUM_WITH_DUPLICATES, $this->headers);
        $this->assertArray->count(SimpleHeaders::HEADERS_NUM, $this->bag->getHeaders());
    }

    public function equals()
    {
        $this->assertArray->notEqual($this->headers, $this->bag->getHeaders());
    }

    public function values()
    {
        foreach ($this->headers as $value) {
            if ($value === '/') {
                $this->assertBoolean->isFalse(in_array($value, $this->bag->getHeaders()));
            } else {
                $this->assertBoolean->isTrue(in_array($value, $this->bag->getHeaders()));
            }
        }
    }

    public function keys()
    {
        $keys = array_keys($this->headers);

        foreach ($keys as $key) {
            if ($key === ':path') {
                $this->assertArray->doesntHaveKey($key, $this->bag->getHeaders());
            } else {
                $this->assertArray->hasKey($key, $this->bag->getHeaders());
            }
        }
    }
}
