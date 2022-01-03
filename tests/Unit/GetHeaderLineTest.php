<?php

declare(strict_types=1);

namespace Quillstack\Tests\HeaderBag;

use PHPUnit\Framework\TestCase;
use Quillstack\HeaderBag\HeaderBag;
use Quillstack\Mocks\HeaderBag\SimpleHeaders;

class GetHeaderLineTest extends TestCase
{
    private HeaderBag $bag;

    protected function setUp(): void
    {
        $headers = (new SimpleHeaders())->headers;
        $this->bag = new HeaderBag($headers);
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
