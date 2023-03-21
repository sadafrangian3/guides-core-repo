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

namespace phpDocumentor\Guides\Twig;

use InvalidArgumentException;
use phpDocumentor\Guides\Nodes\DocumentNode;
use phpDocumentor\Guides\Nodes\Node;
use phpDocumentor\Guides\RenderContext;
use phpDocumentor\Guides\Renderer;
use phpDocumentor\Guides\Renderer\OutputFormatRenderer;
use RuntimeException;

use function sprintf;

final class TwigRenderer implements Renderer
{
    /** @var iterable<OutputFormatRenderer> */
    private iterable $outputFormatRenderers;

    private ?OutputFormatRenderer $outputRenderer = null;
    private EnvironmentBuilder $environmentBuilder;

    /** @param iterable<OutputFormatRenderer> $outputFormatRenderers */
    public function __construct(iterable $outputFormatRenderers, EnvironmentBuilder $environmentBuilder)
    {
        $this->outputFormatRenderers = $outputFormatRenderers;
        $this->environmentBuilder = $environmentBuilder;
    }

    /**
     * @param array<string, mixed> $context
     */
    public function render(string $template, array $context = []): string
    {
        if ($this->outputRenderer === null) {
            throw new RuntimeException('Renderer should be initialized before use');
        }

        return $this->outputRenderer->renderTemplate($template, $context);
    }

    public function renderNode(Node $node, RenderContext $context): string
    {
        $this->setOutputRenderer($context);
        if ($node instanceof DocumentNode) {
            $this->environmentBuilder->setContext($context);
        }

        return $this->outputRenderer->render($node, $context);
    }

    /** @psalm-assert OutputFormatRenderer $this->outputRenderer */
    private function setOutputRenderer(RenderContext $context): void
    {
        foreach ($this->outputFormatRenderers as $outputFormatRenderer) {
            if (!$outputFormatRenderer->supports($context->getOutputFormat())) {
                continue;
            }

            $this->outputRenderer = $outputFormatRenderer;
        }

        if ($this->outputRenderer === null) {
            throw new InvalidArgumentException(
                sprintf('Output format "%s" is not supported', $context->getOutputFormat())
            );
        }
    }
}
