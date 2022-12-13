<?php

declare(strict_types=1);

namespace phpDocumentor\Guides\Compiler;

use phpDocumentor\Guides\Nodes\Node;

interface NodeTransformer
{
    /**
     * @template T of Node
     * @param T $node
     * @return T
     */
    public function enterNode(Node $node): Node;

    /**
     * @template T of Node
     * @param T $node
     * @return T|null
     */
    public function leaveNode(Node $node): ?Node;

    public function supports(Node $node): bool;
}