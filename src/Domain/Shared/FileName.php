<?php declare(strict_types=1);
namespace PackageFactory\KristlBol\Domain\Shared;

final class FileName
{
    /**
     * @var string
     */
    private $value;

    /**
     * @var array<mixed>
     */
    private $pathinfo;

    /**
     * @param string $value
     */
    private function __construct(string $value)
    {
        if (empty($value)) {
            throw FileNameIsInvalid::becauseItIsEmpty();
        }

        if (mb_strpos($value, '/', 0, 'UTF-8') !== false) {
            throw FileNameIsInvalid::becauseItContainsSlashes($value);
        }

        /** @var string $urlPath  */
        $urlPath = parse_url($value, PHP_URL_PATH);
        if ($urlPath !== $value) {
            throw FileNameIsInvalid::becauseItIsNotAValidUrlPath($value);
        }

        $this->value = $value;
        $this->pathinfo = pathinfo($value);
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
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->pathinfo['filename'];
    }

    /**
     * @return string
     */
    public function getExtension(): string
    {
        return $this->pathinfo['extension'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->value;
    }
}