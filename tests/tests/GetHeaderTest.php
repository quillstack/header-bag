<?php

declare(strict_types=1);

namespace Quillstack\Tests\HeaderBag;

use PHPUnit\Framework\TestCase;
use Quillstack\HeaderBag\HeaderBag;
use Quillstack\Mocks\HeaderBag\SimpleHeaders;

final class GetHeaderTest extends TestCase
{
    /**
     * @var HeaderBag
     */
    private HeaderBag $bag;

    protected function setUp(): void
    {
        $headers = (new SimpleHeaders())->headers;
        $this->bag = new HeaderBag($headers);
    }

    public function testHasOneWordHeader()
    {
        $this->assertEquals(['quillstack.com'], $this->bag->getHeader(':authority'));
        $this->assertEquals(['quillstack.com'], $this->bag->getHeader(':aUthority'));
    }

    public function testHasManyWordsHeader()
    {
        $this->assertEquals(['W/"5f5be22a-58c"'], $this->bag->getHeader('if-none-match'));
        $this->assertEquals(['W/"5f5be22a-58c"'], $this->bag->getHeader('If-None-Match'));
    }

    public function testHasManyWordsInValue()
    {
        $this->assertEquals([
            'gzip',
            'deflate',
            'br',
        ], $this->bag->getHeader('accept-encoding'));
    }

    public function testHasCamelCaseWordsHeader()
    {
        $this->assertEquals(['navigate'], $this->bag->getHeader('sec-fetch-mode'));
        $this->assertEquals(['navigate'], $this->bag->getHeader('Sec-Fetch-Mode'));
    }

    public function testDoesntHaveHeader()
    {
        $this->assertEquals([], $this->bag->getHeader(':autority'));
        $this->assertEquals([], $this->bag->getHeader('authority'));
    }

    public function testDoesntHaveManyWordsHeader()
    {
        $this->assertEquals([], $this->bag->getHeader('ifnonematch'));
        $this->assertEquals([], $this->bag->getHeader('IfNoneMatch'));
    }

    public function testDoesntHaveCamelCaseWordsHeader()
    {
        $this->assertEquals([], $this->bag->getHeader('secfetchmode'));
        $this->assertEquals([], $this->bag->getHeader('SecFetchMode'));
    }
}
