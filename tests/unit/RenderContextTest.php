<?php

declare(strict_types=1);

namespace phpDocumentor\Guides;

use League\Flysystem\FilesystemInterface;
use phpDocumentor\Guides\Meta\DocumentEntry;
use phpDocumentor\Guides\Nodes\DocumentNode;
use phpDocumentor\Guides\Nodes\TitleNode;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;

use function md5;

final class RenderContextTest extends TestCase
{
    use ProphecyTrait;

    /** @dataProvider documentPathProvider */
    public function testRelativeDocUrl(
        string $filePath,
        string $destinationPath,
        string $linkedDocument,
        string $result,
        ?string $anchor = null
    ): void {
        $documentNode = new DocumentNode(md5('hash'), $filePath);

        $context = RenderContext::forDocument(
            $documentNode,
            $this->prophesize(FilesystemInterface::class)->reveal(),
            $this->prophesize(FilesystemInterface::class)->reveal(),
            $destinationPath,
            new Metas([
                'getting-started/configuration' => new DocumentEntry(
                    'getting-started/configuration',
                    TitleNode::emptyNode()
                ),
            ]),
            new UrlGenerator(),
            'txt'
        );

        self::assertSame($result, $context->relativeDocUrl($linkedDocument, $anchor));
    }

    /** @return string[][] */
    public function documentPathProvider(): array
    {
        return [
            [
                'filePath' => 'getting-started/configuration',
                'destinationPath' => 'guide/',
                'linkedDocument' => 'installing',
                'result' => 'guide/getting-started/installing.txt',
            ],
            [
                'filePath' => 'getting-started/configuration',
                'destinationPath' => 'guide/',
                'linkedDocument' => '/installing',
                'result' => 'guide/installing.txt',
            ],
            [
                'filePath' => 'getting-started/configuration',
                'destinationPath' => 'guide',
                'linkedDocument' => 'getting-started/configuration',
                'result' => 'guide/getting-started/configuration.txt#composer',
                'anchor' => 'composer',
            ],
            [
                'filePath' => 'getting-started/configuration',
                'destinationPath' => 'guide/',
                'linkedDocument' => '../references/installing',
                'result' => 'guide/references/installing.txt',
            ],
        ];
    }
}
