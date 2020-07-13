<?php declare(strict_types=1);
namespace PackageFactory\KristlBol\Domain\Node;

use Psr\Http\Message\UriInterface;

final class Path
{
    /**
     * @var string
     */
    private $value;

    /**
     * @param string $value
     */
    protected function __construct(string $value)
    {
        if (empty($value)) {
            throw PathIsInvalid::becauseItIsEmpty();
        }

        if ($value[0] !== '/') {
            throw PathIsInvalid::becauseItDoesNotStartWithALeadingSlash($value);
        }

        /** @var string $urlPath  */
        $urlPath = parse_url($value, PHP_URL_PATH);
        if ($urlPath !== $value) {
            throw PathIsInvalid::becauseItIsNotAValidUrlPath($value);
        }

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
     * @param UriInterface $uri
     * @return self
     */
    public static function fromUri(UriInterface $uri): self
    {
        return new self($uri->getPath());
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @return FileName
     */
    public function getFileName(): FileName
    {
        return FileName::fromString(basename($this->value));
    }

    /**
     * @param FileName $fileName
     * @return Path
     */
    public function withAppendedFileName(FileName $fileName): Path
    {
        $pathinfo = pathinfo($this->value);

        return new self(
            sprintf('%s/%s/%s', $pathinfo['dirname'], $pathinfo['filename'], $fileName)
        );
    }

    /**
     * @param string $prefix
     * @return boolean
     */
    public function startsWith(string $prefix): bool
    {
        return mb_strpos((string)$this->value, $prefix, null, 'UTF-8') === 0;
    }

    /**
     * @param string $suffix
     * @return boolean
     */
    public function endsWith(string $suffix): bool
    {
        $position = mb_strlen($this->value, 'UTF-8');
        $position = $position - mb_strlen($suffix, 'UTF-8');

        return mb_strrpos($this->value, $suffix, null, 'UTF-8') === $position;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->value;
    }
}