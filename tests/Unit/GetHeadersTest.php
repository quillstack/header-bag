<?php

declare(strict_types=1);

namespace Quillstack\HeaderBag\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Quillstack\HeaderBag\HeaderBag;
use Quillstack\HeaderBag\Tests\Mocks\SimpleHeaders;

class GetHeadersTest extends TestCase
{
    private HeaderBag $bag;
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
        $this->assertCount(SimpleHeaders::HEADERS_NUM_WITH_DUPLICATES, $this->headers);
        $this->assertCount(SimpleHeaders::HEADERS_NUM, $this->bag->getHeaders());
    }

    public function testEquals()
    {
        $this->assertNotEquals($this->headers, $this->bag->getHeaders());
    }

    public function testValues()
    {
        foreach ($this->headers as $value) {
            if ($value === '/') {
                $this->assertFalse(in_array($value, $this->bag->getHeaders()));
            } else {
                $this->assertTrue(in_array($value, $this->bag->getHeaders()));
            }
        }
    }

    public function testKeys()
    {
        $keys = array_keys($this->headers);

        foreach ($keys as $key) {
            if ($key === ':path') {
                $this->assertArrayNotHasKey($key, $this->bag->getHeaders());
            } else {
                $this->assertArrayHasKey($key, $this->bag->getHeaders());
            }
        }
    }
}
