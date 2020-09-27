<?php

declare(strict_types=1);

namespace QuillStack\Http\HeaderBag;

use PHPUnit\Framework\TestCase;
use QuillStack\Mocks\HeaderBag\SimpleHeaders;

final class GetHeaderLineTest extends TestCase
{

    /**
     * @var HeaderBag
     */
    private HeaderBag $bag;

    /**
     * @var string[]
     */
    private array $headers;

    protected function setUp(): void
    {
        $this->headers = (new SimpleHeaders())->headers;
        $this->bag = new HeaderBag($this->headers);
    }

    public function testHasOneWordHeader()
    {
        $this->assertEquals('quillstack.com', $this->bag->getHeaderLine(':authority'));
    }

    public function testHasManyWordsHeader()
    {
        $this->assertEquals('W/"5f5be22a-58c"', $this->bag->getHeaderLine('if-none-match'));
    }

    public function testHasManyWordsInValue()
    {
        $this->assertEquals('gzip, deflate, br', $this->bag->getHeaderLine('accept-encoding'));
    }

    public function testHasCamelCaseWordsHeader()
    {
        $this->assertEquals('navigate', $this->bag->getHeaderLine('sec-fetch-mode'));
    }

    public function testDoesntHaveHeader()
    {
        $this->assertEquals('', $this->bag->getHeaderLine(':autority'));
    }

    public function testDoesntHaveManyWordsHeader()
    {
        $this->assertEquals('', $this->bag->getHeaderLine('ifnonematch'));
    }

    public function testDoesntHaveCamelCaseWordsHeader()
    {
        $this->assertEquals('', $this->bag->getHeaderLine('secfetchmode'));
    }
}
