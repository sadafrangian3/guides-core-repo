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

namespace phpDocumentor\Guides\Nodes;

use function implode;

class CodeNode extends TextNode
{
    protected ?string $language = null;

    /** @var int|null The line number to start counting from and display, or null to hide line numbers */
    private ?int $startingLineNumber = null;

    /**
     * @param string[] $lines
     */
    public function __construct(array $lines)
    {
        parent::__construct(implode("\n", $lines));
    }

    public function setLanguage(?string $language = null): void
    {
        $this->language = $language;
    }

    public function getLanguage(): ?string
    {
        return $this->language;
    }

    public function setStartingLineNumber(?int $lineNumber): void
    {
        $this->startingLineNumber = $lineNumber;
    }

    public function getStartingLineNumber(): ?int
    {
        return $this->startingLineNumber;
    }
}
