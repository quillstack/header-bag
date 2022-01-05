<?php

declare(strict_types=1);

namespace Quillstack\HeaderBag\Tests\Mocks;

class SimpleHeaders
{
    public const HEADERS_NUM = 17;
    public const HEADERS_NUM_WITH_DUPLICATES = 18;

    public array $headers = [
        ':authority' => 'quillstack.com',
        ':method' => 'GET',
        'UPPER' => 'case',
        ':path' => '/',
        ':scheme' => 'https',
        'accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,'
            . 'application/signed-exchange;v=b3;q=0.9',
        'accept-encoding' => 'gzip, deflate, br',
        'accept-language' => 'en-GB,en;q=0.9,en-US;q=0.8,pl;q=0.7',
        'cache-control' => 'max-age=0',
        ':PATH' => '/abc',
        'if-modified-since' => 'Fri, 11 Sep 2020 20:46:34 GMT',
        'if-none-match' => 'W/"5f5be22a-58c"',
        'sec-fetch-dest' => 'document',
        'Sec-Fetch-Mode' => 'navigate',
        'sec-fetch-site' => 'none',
        'sec-fetch-user' => '?1',
        'upgrade-insecure-requests' => '1',
        'user-agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_4) AppleWebKit/537.36 (KHTML, like Gecko)'
            . ' Chrome/84.0.4147.135 Safari/537.36',
    ];
}
