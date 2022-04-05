<?php

declare(strict_types=1);

namespace Davajlama;

final class ParseException extends \Exception
{
    public static function fromThrowable(\Throwable $throwable): self
    {
        return new self('One of the supplied PDF documents is not supported.', $throwable->getCode(), $throwable);
    }
}
