<?php declare(strict_types=1);
namespace PackageFactory\KristlBol\Infrastructure\Shared\Content;

use PackageFactory\KristlBol\Domain\Shared\ContentInterface;

final class StringContent implements ContentInterface
{
    /**
     * @var string
     */
    private $value;

    /**
     * @param string $value
     */
    private function __construct(string $value)
    {
        $this->value = $value;
    }

    /**
     * @param string $string
     * @return self
     */
    public static function fromString(string $string): self
    {
        return new self($string);
    }

    /**
     * @return resource
     */
    public function toStream()
    {
        $stream = fopen('php://memory','r+');
        fwrite($stream, $this->value);
        rewind($stream);
        return $stream;
    }
}

