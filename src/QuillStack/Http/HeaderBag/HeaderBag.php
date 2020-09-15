<?php

declare(strict_types=1);

namespace QuillStack\Http\HeaderBag;

use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\StreamInterface;

final class HeaderBag implements MessageInterface
{
    /**
     * @var array
     */
    private array $headers;

    /**
     * @var array
     */
    private array $headersKeys;

    /**
     * HeaderBag constructor.
     *
     * @param array $headers
     */
    public function __construct(array $headers)
    {
        $this->headers = $headers;
        $this->headersKeys = array_map('strtolower', array_keys($this->headers));
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
        return in_array(strtolower($name), $this->headersKeys);
    }

    /**
     * @param $name
     *
     * @return int
     */
    private function getHeaderIndex($name): int
    {
        return array_search(strtolower($name), $this->headersKeys);
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

        return explode(',', array_values($this->headers)[$index]);
    }

    /**
     * {@inheritDoc}
     */
    public function getHeaderLine($name)
    {
        $header = $this->getHeader($name);

        if ($header === []) {
            return '';
        }

        return current($header);
    }

    /**
     * {@inheritDoc}
     */
    public function withHeader($name, $value)
    {
        if (!is_string($name)) {
            throw new InvalidArgumentException('Header name is not string');
        }

        if (!is_string($value) && !is_array($value)) {
            throw new InvalidArgumentException('Header value is not string or array');
        }

        $new = clone $this;
        $new->headers[$name] = $value;
        $keyName = strtolower($name);

        if (!in_array($keyName, $new->headersKeys)) {
            $new->headersKeys[] = $keyName;
        }

        return $new;
    }

    /**
     * {@inheritDoc}
     */
    public function withAddedHeader($name, $value)
    {
        $new = clone $this;

        if ($this->hasHeader($name)) {
            return $new;
        }

        return $new->withHeader($name, $value);
    }

    /**
     * @param int $index
     *
     * @return string
     */
    private function getHeaderKeyByIndex(int $index): string
    {
        return array_keys($this->headers)[$index];
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

        unset($new->headersKeys[$index]);
        unset($new->headers[$key]);

        return $new;
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
