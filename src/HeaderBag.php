<?php

declare(strict_types=1);

namespace Quillstack\HeaderBag;

use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\StreamInterface;
use Quillstack\HeaderBag\Exceptions\InvalidHeaderArgumentException;
use Quillstack\HeaderBag\Exceptions\MethodNotImplementedException;

class HeaderBag implements MessageInterface
{
    /**
     * Internal array to store all header keys to optimise search.
     */
    private array $headersKeys = [];

    /**
     * Constructor.
     */
    public function __construct(private array $headers = [])
    {
        $this->filterUniqueValues();
    }

    /**
     * {@inheritDoc}
     */
    public function getHeader($name)
    {
        if (!$this->hasHeader($name)) {
            return [];
        }

        $index = $this->getHeaderIndex($name);

        return array_map('trim', explode(',', array_values($this->headers)[$index]));
    }

    /**
     * {@inheritDoc}
     */
    public function getHeaderLine($name)
    {
        if (!$this->hasHeader($name)) {
            return '';
        }

        $index = $this->getHeaderIndex($name);

        return array_values($this->headers)[$index];
    }

    /**
     * {@inheritDoc}
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * {@inheritDoc}
     */
    public function hasHeader($name)
    {
        return isset($this->headersKeys[strtolower($name)]);
    }

    /**
     * {@inheritDoc}
     */
    public function withAddedHeader($name, $value)
    {
        $this->validateNameAndValue($name, $value);

        if (is_string($value)) {
            $value = [$value];
        }

        $new = clone $this;

        if ($this->hasHeader($name)) {
            $value = $this->getHeaderLine($name) . ',' . implode(',', $value);
        }

        return $new->withHeader($name, $value);
    }

    /**
     * {@inheritDoc}
     */
    public function withHeader($name, $value)
    {
        $this->validateNameAndValue($name, $value);

        if (is_string($value)) {
            $value = [$value];
        }

        $headers = $this->headers;
        $headers[$name] = implode(',', $value);

        return new self($headers);
    }

    /**
     * {@inheritDoc}
     */
    public function withoutHeader($name)
    {
        $new = clone $this;

        if (!$this->hasHeader($name)) {
            return $new;
        }

        $index = $this->getHeaderIndex($name);
        $key = $this->getHeaderKeyByIndex($index);

        unset($new->headersKeys[strtolower($key)]);
        unset($new->headers[$key]);

        return $new;
    }

    /**
     * Create unique headers array.
     */
    private function filterUniqueValues()
    {
        $headers = [];

        foreach ($this->headers as $key => $header) {
            $lowerKey = strtolower($key);

            if (!isset($this->headersKeys[$lowerKey])) {
                $this->headersKeys[$lowerKey] = $key;
                $headers[$key] = $header;
            } elseif (isset($this->headersKeys[$lowerKey]) && isset($headers[$this->headersKeys[$lowerKey]])) {
                unset($headers[$this->headersKeys[$lowerKey]]);
                unset($this->headersKeys[$lowerKey]);

                $this->headersKeys[$lowerKey] = $key;
                $headers[$this->headersKeys[$lowerKey]] = $header;
            }
        }

        $this->headers = $headers;
    }

    /**
     * Gets the header index from the internal headersKeys array.
     */
    private function getHeaderIndex(string $name): int
    {
        return array_search(strtolower($name), array_keys($this->headersKeys));
    }

    /**
     * Gets the header key by its index.
     */
    private function getHeaderKeyByIndex(int $index): string
    {
        return array_keys($this->headers)[$index];
    }

    /**
     * Validates the header name and the header value.
     */
    private function validateNameAndValue($name, $value): void
    {
        if (!is_string($name)) {
            throw new InvalidHeaderArgumentException('Header name is not string');
        }

        if (!is_string($value) && !is_array($value)) {
            throw new InvalidHeaderArgumentException('Header value is neither string nor array');
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getProtocolVersion()
    {
        throw new MethodNotImplementedException('Method `getProtocolVersion` doesn\'t exist');
    }

    /**
     * {@inheritDoc}
     */
    public function withProtocolVersion($version)
    {
        throw new MethodNotImplementedException('Method `withProtocolVersion` doesn\'t exist');
    }

    /**
     * {@inheritDoc}
     */
    public function getBody()
    {
        throw new MethodNotImplementedException('Method `getBody` doesn\'t exist');
    }

    /**
     * {@inheritDoc}
     */
    public function withBody(StreamInterface $body)
    {
        throw new MethodNotImplementedException('Method `withBody` doesn\'t exist');
    }
}
