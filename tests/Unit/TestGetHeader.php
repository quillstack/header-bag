<?php

declare(strict_types=1);

namespace Quillstack\HeaderBag\Tests\Unit;

use Quillstack\HeaderBag\HeaderBag;
use Quillstack\HeaderBag\Tests\Mocks\SimpleHeaders;
use Quillstack\UnitTests\AssertEqual;

class TestGetHeader
{
    private HeaderBag $bag;

    public function __construct(private AssertEqual $assertEqual)
    {
        $headers = (new SimpleHeaders())->headers;
        $this->bag = new HeaderBag($headers);
    }

    public function hasOneWordHeader()
    {
        $this->assertEqual->equal(['quillstack.com'], $this->bag->getHeader(':authority'));
        $this->assertEqual->equal(['quillstack.com'], $this->bag->getHeader(':aUthority'));
    }

    public function hasManyWordsHeader()
    {
        $this->assertEqual->equal(['W/"5f5be22a-58c"'], $this->bag->getHeader('if-none-match'));
        $this->assertEqual->equal(['W/"5f5be22a-58c"'], $this->bag->getHeader('If-None-Match'));
    }

    public function hasManyWordsInValue()
    {
        $this->assertEqual->equal([
            'gzip',
            'deflate',
            'br',
        ], $this->bag->getHeader('accept-encoding'));
    }

    public function hasCamelCaseWordsHeader()
    {
        $this->assertEqual->equal(['navigate'], $this->bag->getHeader('sec-fetch-mode'));
        $this->assertEqual->equal(['navigate'], $this->bag->getHeader('Sec-Fetch-Mode'));
    }

    public function doesntHaveHeader()
    {
        $this->assertEqual->equal([], $this->bag->getHeader(':autority'));
        $this->assertEqual->equal([], $this->bag->getHeader('authority'));
    }

    public function doesntHaveManyWordsHeader()
    {
        $this->assertEqual->equal([], $this->bag->getHeader('ifnonematch'));
        $this->assertEqual->equal([], $this->bag->getHeader('IfNoneMatch'));
    }

    public function doesntHaveCamelCaseWordsHeader()
    {
        $this->assertEqual->equal([], $this->bag->getHeader('secfetchmode'));
        $this->assertEqual->equal([], $this->bag->getHeader('SecFetchMode'));
    }
}
