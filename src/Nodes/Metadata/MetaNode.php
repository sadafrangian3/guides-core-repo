<?php

declare(strict_types=1);

/**
 * This file is part of phpDocumentor.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @link https://phpdoc.org
 */

namespace phpDocumentor\Guides\Nodes\Metadata;

class MetaNode extends MetadataNode
{
    protected string $key;

    public function __construct(string $key, string $value)
    {
        $this->key = $key;

        parent::__construct($value);
    }

    public function getKey(): string
    {
        return $this->key;
    }
}
