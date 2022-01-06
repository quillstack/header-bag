<?php

declare(strict_types=1);

namespace Quillstack\HeaderBag\Tests\Unit;

use Quillstack\HeaderBag\HeaderBag;
use Quillstack\HeaderBag\Tests\Mocks\SimpleHeaders;
use Quillstack\UnitTests\Types\AssertBoolean;

class TestHasHeader
{
    private HeaderBag $bag;

    public function __construct(private AssertBoolean $assertBoolean)
    {
        $headers = (new SimpleHeaders())->headers;
        $this->bag = new HeaderBag($headers);
    }

    public function hasOneWordHeader()
    {
        $this->assertBoolean->isTrue($this->bag->hasHeader(':authority'));
        $this->assertBoolean->isTrue($this->bag->hasHeader(':aUthority'));
    }

    public function hasManyWordsHeader()
    {
        $this->assertBoolean->isTrue($this->bag->hasHeader('if-none-match'));
        $this->assertBoolean->isTrue($this->bag->hasHeader('If-None-Match'));
    }

    public function hasCamelCaseWordsHeader()
    {
        $this->assertBoolean->isTrue($this->bag->hasHeader('sec-fetch-mode'));
        $this->assertBoolean->isTrue($this->bag->hasHeader('Sec-Fetch-Mode'));
    }

    public function doesntHaveHeader()
    {
        $this->assertBoolean->isFalse($this->bag->hasHeader(':autority'));
        $this->assertBoolean->isFalse($this->bag->hasHeader('authority'));
    }

    public function doesntHaveManyWordsHeader()
    {
        $this->assertBoolean->isFalse($this->bag->hasHeader('ifnonematch'));
        $this->assertBoolean->isFalse($this->bag->hasHeader('IfNoneMatch'));
    }

    public function doesntHaveCamelCaseWordsHeader()
    {
        $this->assertBoolean->isFalse($this->bag->hasHeader('secfetchmode'));
        $this->assertBoolean->isFalse($this->bag->hasHeader('SecFetchMode'));
    }
}
