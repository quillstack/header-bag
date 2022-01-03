<?php

declare(strict_types=1);

namespace Quillstack\HeaderBag\Tests\Unit;

use Quillstack\HeaderBag\HeaderBag;
use Quillstack\HeaderBag\Tests\Mocks\SimpleHeaders;
use Quillstack\UnitTests\AssertEqual;

class TestGetHeaderLine
{
    private HeaderBag $bag;

    public function __construct(private AssertEqual $assertEqual)
    {
        $headers = (new SimpleHeaders())->headers;
        $this->bag = new HeaderBag($headers);
    }

    public function hasOneWordHeader()
    {
        $this->assertEqual->equal('quillstack.com', $this->bag->getHeaderLine(':authority'));
    }

    public function hasManyWordsHeader()
    {
        $this->assertEqual->equal('W/"5f5be22a-58c"', $this->bag->getHeaderLine('if-none-match'));
    }

    public function hasManyWordsInValue()
    {
        $this->assertEqual->equal('gzip, deflate, br', $this->bag->getHeaderLine('accept-encoding'));
    }

    public function hasCamelCaseWordsHeader()
    {
        $this->assertEqual->equal('navigate', $this->bag->getHeaderLine('sec-fetch-mode'));
    }

    public function doesntHaveHeader()
    {
        $this->assertEqual->equal('', $this->bag->getHeaderLine(':autority'));
    }

    public function doesntHaveManyWordsHeader()
    {
        $this->assertEqual->equal('', $this->bag->getHeaderLine('ifnonematch'));
    }

    public function doesntHaveCamelCaseWordsHeader()
    {
        $this->assertEqual->equal('', $this->bag->getHeaderLine('secfetchmode'));
    }
}
