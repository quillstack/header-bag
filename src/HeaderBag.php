<?php

declare(strict_types=1);

namespace Quillstack\HeaderBag;

use Quillstack\HeaderBag\Exceptions\InvalidHeaderArgumentException;

class HeaderBag implements HeaderBagInterface
{
    /**
     * The values of every header, keyed by the name it was given under.
     *
     * @var array<string, string[]>
     */
    private array $headers = [];

    /**
     * Maps a lowercased name to the name the header is stored under, so a header can be
     * found whatever case it is asked for.
     *
     * @var array<string, string>
     */
    private array $names = [];

    /**
     * @param array<string, string|string[]> $headers
     */
    public function __construct(array $headers = [])
    {
        foreach ($headers as $name => $value) {
            $this->set((string) $name, $value);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * {@inheritDoc}
     */
    public function getHeader(string $name): array
    {
        return $this->headers[$this->names[strtolower($name)] ?? ''] ?? [];
    }

    /**
     * {@inheritDoc}
     */
    public function getHeaderLine(string $name): string
    {
        return implode(', ', $this->getHeader($name));
    }

    /**
     * {@inheritDoc}
     */
    public function hasHeader(string $name): bool
    {
        return isset($this->names[strtolower($name)]);
    }

    /**
     * {@inheritDoc}
     */
    public function withHeader(string $name, string|array $value): static
    {
        $new = clone $this;
        $new->remove($name);
        $new->set($name, $value);

        return $new;
    }

    /**
     * {@inheritDoc}
     */
    public function withAddedHeader(string $name, string|array $value): static
    {
        $new = clone $this;
        $new->set($name, $value, true);

        return $new;
    }

    /**
     * {@inheritDoc}
     */
    public function withoutHeader(string $name): static
    {
        $new = clone $this;
        $new->remove($name);

        return $new;
    }

    /**
     * Stores the values of a header, either replacing what was there or adding to it. A
     * name already known under a different case keeps the case it was first stored with.
     *
     * @param string|string[] $value
     */
    private function set(string $name, mixed $value, bool $add = false): void
    {
        $values = $this->readValues($value);
        $key = strtolower($name);
        $storedName = $this->names[$key] ?? $name;

        $this->names[$key] = $storedName;
        $this->headers[$storedName] = $add
            ? [...$this->headers[$storedName] ?? [], ...$values]
            : $values;
    }

    private function remove(string $name): void
    {
        $key = strtolower($name);

        if (!isset($this->names[$key])) {
            return;
        }

        unset($this->headers[$this->names[$key]], $this->names[$key]);
    }

    /**
     * A header holds a list of values. One string is one value: a string carrying commas
     * is a single field value, not several, which is what keeps dates and cookies whole.
     *
     * @return string[]
     */
    private function readValues(mixed $value): array
    {
        if (!is_string($value) && !is_array($value)) {
            throw new InvalidHeaderArgumentException('Header value is neither a string nor an array of strings');
        }

        $values = is_array($value) ? $value : [$value];

        foreach ($values as $one) {
            if (!is_string($one)) {
                throw new InvalidHeaderArgumentException('Header values have to be strings');
            }
        }

        return array_values($values);
    }
}
