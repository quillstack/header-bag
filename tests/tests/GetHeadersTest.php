<?php

declare(strict_types=1);

namespace Quillstack\Tests\HeaderBag;

use PHPUnit\Framework\TestCase;
use Quillstack\HeaderBag\HeaderBag;
use Quillstack\Mocks\HeaderBag\SimpleHeaders;

final class GetHeadersTest extends TestCase
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

    public function testType()
    {
        $this->assertIsArray($this->bag->getHeaders());
    }

    public function testCount()
    {
        $this->assertCount(16, $this->headers);
        $this->assertCount(16, $this->bag->getHeaders());
    }

    public function testEquals()
    {
        $this->assertEquals($this->headers, $this->bag->getHeaders());
    }

    public function testValues()
    {
        foreach ($this->headers as $header) {
            $this->assertTrue(in_array($header, $this->bag->getHeaders()));
        }
    }

    public function testKeys()
    {
        $keys = array_keys($this->headers);

        foreach ($keys as $key) {
            $this->assertArrayHasKey($key, $this->bag->getHeaders());
        }
    }
}
