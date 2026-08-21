<?php

declare(strict_types=1);

namespace Quillstack\HeaderBag;

/**
 * A collection of HTTP headers, following the rules PSR-7 sets for them: names are matched
 * without regard to case, and every header holds a list of values.
 */
interface HeaderBagInterface
{
    /**
     * All headers, keyed by the name they were given under.
     *
     * @return array<string, string[]>
     */
    public function getHeaders(): array;

    /**
     * The values of one header, or an empty array when there is no such header.
     *
     * @return string[]
     */
    public function getHeader(string $name): array;

    /**
     * The values of one header joined with a comma, or an empty string when there is no
     * such header.
     */
    public function getHeaderLine(string $name): string;

    public function hasHeader(string $name): bool;

    /**
     * Returns a copy where the header holds exactly the given value.
     *
     * @param string|string[] $value
     */
    public function withHeader(string $name, string|array $value): static;

    /**
     * Returns a copy where the given value is added to whatever the header already holds.
     *
     * @param string|string[] $value
     */
    public function withAddedHeader(string $name, string|array $value): static;

    /**
     * Returns a copy without the given header.
     */
    public function withoutHeader(string $name): static;
}
