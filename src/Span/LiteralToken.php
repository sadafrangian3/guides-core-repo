<?php

declare(strict_types=1);

namespace phpDocumentor\Guides\Span;

final class LiteralToken extends ValueToken
{
    public const TYPE = 'literal';

    public function __construct(string $id, string $value)
    {
        parent::__construct(self::TYPE, $id, $value);
    }
}
