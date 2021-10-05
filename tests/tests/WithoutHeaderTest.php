<?php

declare(strict_types=1);

namespace Quillstack\Tests\HeaderBag;

use PHPUnit\Framework\TestCase;
use Quillstack\HeaderBag\HeaderBag;
use Quillstack\Mocks\HeaderBag\SimpleHeaders;

final class WithoutHeaderTest extends TestCase
{
    private const NEW_HEADER = 'new-header';

    private const EXISTING_HEADER = ':path';

    /**
     * @var HeaderBag
     */
    private HeaderBag $bag;

    protected function setUp(): void
    {
        $headers = (new SimpleHeaders())->headers;
        $this->bag = new HeaderBag($headers);
    }

    public function testWithNewHeader()
    {
        $bag = $this->bag->withoutHeader(self::NEW_HEADER, 'test');

        $this->assertCount(16, $this->bag->getHeaders());
        $this->assertCount(16, $bag->getHeaders());

        $this->assertFalse($this->bag->hasHeader(self::NEW_HEADER));
        $this->assertFalse($bag->hasHeader(self::NEW_HEADER));

        $this->assertEquals('', $this->bag->getHeaderLine(self::NEW_HEADER));
        $this->assertEquals('', $bag->getHeaderLine(self::NEW_HEADER));
    }

    public function testWithExistingHeader()
    {
        $bag = $this->bag->withoutHeader(self::EXISTING_HEADER, '/test');

        $this->assertCount(16, $this->bag->getHeaders());
        $this->assertCount(15, $bag->getHeaders());

        $this->assertTrue($this->bag->hasHeader(self::EXISTING_HEADER));
        $this->assertFalse($bag->hasHeader(self::EXISTING_HEADER));

        $this->assertEquals('/', $this->bag->getHeaderLine(self::EXISTING_HEADER));
        $this->assertEquals('', $bag->getHeaderLine(self::EXISTING_HEADER));
    }
}
