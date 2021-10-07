<?php

declare(strict_types=1);

namespace Quillstack\Tests\HeaderBag;

use PHPUnit\Framework\TestCase;
use Quillstack\HeaderBag\HeaderBag;
use Quillstack\Mocks\HeaderBag\SimpleHeaders;

class HasHeaderTest extends TestCase
{
    private HeaderBag $bag;

    public function setUp(): void
    {
        $headers = (new SimpleHeaders())->headers;
        $this->bag = new HeaderBag($headers);
    }

    public function testHasOneWordHeader()
    {
        $this->assertTrue($this->bag->hasHeader(':authority'));
        $this->assertTrue($this->bag->hasHeader(':aUthority'));
    }

    public function testHasManyWordsHeader()
    {
        $this->assertTrue($this->bag->hasHeader('if-none-match'));
        $this->assertTrue($this->bag->hasHeader('If-None-Match'));
    }

    public function testHasCamelCaseWordsHeader()
    {
        $this->assertTrue($this->bag->hasHeader('sec-fetch-mode'));
        $this->assertTrue($this->bag->hasHeader('Sec-Fetch-Mode'));
    }

    public function testDoesntHaveHeader()
    {
        $this->assertFalse($this->bag->hasHeader(':autority'));
        $this->assertFalse($this->bag->hasHeader('authority'));
    }

    public function testDoesntHaveManyWordsHeader()
    {
        $this->assertFalse($this->bag->hasHeader('ifnonematch'));
        $this->assertFalse($this->bag->hasHeader('IfNoneMatch'));
    }

    public function testDoesntHaveCamelCaseWordsHeader()
    {
        $this->assertFalse($this->bag->hasHeader('secfetchmode'));
        $this->assertFalse($this->bag->hasHeader('SecFetchMode'));
    }
}
