<?php

declare(strict_types=1);

namespace Quillstack\HeaderBag\Tests\DataProviders;

use Quillstack\UnitTests\DataProviderInterface;

class InvalidHeaderValueDataProvider implements DataProviderInterface
{
    public function provides(): array
    {
        return [
            [3],
            [false],
            [true],
            [new \stdClass()],
            [-1.23],
            [null],
        ];
    }
}
