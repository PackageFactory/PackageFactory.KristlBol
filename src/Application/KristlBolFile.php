<?php declare(strict_types=1);
namespace PackageFactory\KristlBol\Application;

use League\Flysystem\Adapter\Local;
use League\Flysystem\AdapterInterface;
use PackageFactory\KristlBol\Domain\Body;
use PackageFactory\KristlBol\Domain\Document;
use PackageFactory\VirtualDOM\Attributes;
use PackageFactory\VirtualDOM\Element;
use PackageFactory\VirtualDOM\ElementType;
use PackageFactory\VirtualDOM\NodeList;
use PackageFactory\VirtualDOM\Text;
use Psr\Http\Message\UriInterface;

abstract class KristlBolFile
{
    final public function __construct()
    {
    }

    /**
     * @return string
     */
    public function describe(): string
    {
        return 'New KristlBol Project';
    }

    /**
     * @return AdapterInterface
     */
    public function output(): AdapterInterface
    {
        return new Local(getcwd() . DIRECTORY_SEPARATOR . 'dist');
    }

    /**
     * @return \Iterator<string, Document>
     */
    public function documents(): \Iterator
    {
        yield Document::empty('/index.html')
            ->withBody(
                Body::empty()->withChildren(
                    NodeList::create(
                        Element::create(
                            ElementType::fromTagName('h1'),
                            Attributes::createEmpty(),
                            NodeList::create(
                                Text::fromString('Welcome to ' . $this->describe())
                            )
                        )
                    )
                )
            );
    }

    /**
     * @param UriInterface $request
     * @return Document|null
     */
    public function document(UriInterface $uri): ?Document
    {
        return null;
    }
}