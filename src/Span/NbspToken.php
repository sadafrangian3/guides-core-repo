<?php

declare(strict_types=1);

namespace phpDocumentor\Guides\Span;

final class NbspToken extends SpanToken
{
    public const TYPE = 'nbsp';

    public function __construct(string $id)
    {
        parent::__construct(self::TYPE, $id, []);
    }
}
