<?php

namespace Joussin\Component\Container;

class NotFoundException implements \Psr\Container\NotFoundExceptionInterface
{

    /**
     * @inheritDoc
     */
    public function getMessage(): string
    {
        // TODO: Implement getMessage() method.
    }

    /**
     * @inheritDoc
     */
    public function getCode()
    {
        // TODO: Implement getCode() method.
    }

    /**
     * @inheritDoc
     */
    public function getFile(): string
    {
        // TODO: Implement getFile() method.
    }

    /**
     * @inheritDoc
     */
    public function getLine(): int
    {
        // TODO: Implement getLine() method.
    }

    /**
     * @inheritDoc
     */
    public function getTrace(): array
    {
        // TODO: Implement getTrace() method.
    }

    /**
     * @inheritDoc
     */
    public function getTraceAsString(): string
    {
        // TODO: Implement getTraceAsString() method.
    }

    /**
     * @inheritDoc
     */
    public function getPrevious()
    {
        // TODO: Implement getPrevious() method.
    }

    /**
     * @inheritDoc
     */
    public function __toString()
    {
        // TODO: Implement __toString() method.
    }
}