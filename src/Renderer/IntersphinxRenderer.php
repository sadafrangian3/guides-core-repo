<?php

declare(strict_types=1);

namespace phpDocumentor\Guides\Renderer;

use phpDocumentor\Guides\Handlers\RenderCommand;
use phpDocumentor\Guides\UrlGenerator;

use function json_encode;

use const JSON_PRETTY_PRINT;

class IntersphinxRenderer implements TypeRenderer
{
    public const TYPE = 'intersphinx';

    public function supports(string $outputFormat): bool
    {
        return $outputFormat === self::TYPE;
    }

    public function render(RenderCommand $renderCommand): void
    {
        $inventory = [
            'std:doc' => [],
        ];
        $urlGenerator = new UrlGenerator();
        foreach ($renderCommand->getMetas()->getAll() as $key => $documentEntry) {
            $url = $urlGenerator->canonicalUrl(
                '',
                $urlGenerator->createFileUrl($documentEntry->getFile(), 'html')
            );
            $inventory['std:doc'][$key] = [
                '',
                '',
                $url,
                $documentEntry->getTitle()->toString(),
            ];
        }

        $json = (string) json_encode($inventory, JSON_PRETTY_PRINT);
        $renderCommand->getDestination()->put(
            'objects.inv.json',
            $json
        );
    }
}
