<?php

declare(strict_types=1);

namespace Adlogix\EventScheduler\ValueObject;

use DateTime;
use Webmozart\Assert\Assert;

/**
 * @author Toni Van de Voorde <toni@adlogix.eu>
 */
final class Trimester
{
    /**
     * @var int
     */
    private $value;

    /**
     * @param int $value
     */
    private function __construct(int $value)
    {
        Assert::range($value, 1, 4);
        $this->value = $value;
    }

    /**
     * @return int
     */
    public function value(): int
    {
        return $this->value;
    }

    /**
     * @param Trimester $trimester
     * @return bool
     */
    public function equals(Trimester $trimester): bool
    {
        return $this->value === $trimester->value();
    }

    /**
     * @return Trimester
     */
    public static function first(): self
    {
        return new self(1);
    }

    /**
     * @return Trimester
     */
    public static function second(): self
    {
        return new self(2);
    }

    /**
     * @return Trimester
     */
    public static function third(): self
    {
        return new self(3);
    }

    /**
     * @return Trimester
     */
    public static function fourth(): self
    {
        return new self(4);
    }

    /**
     * @return Trimester
     */
    public static function now(): self
    {
        $now = new DateTime('now');
        return self::fromNDateTime($now);
    }

    /**
     * @param \DateTimeInterface $date
     * @return Trimester
     */
    public static function fromNDateTime(\DateTimeInterface $date): self
    {
        $semester = ceil($date->format('n') / 3);
        return new self((int)$semester);
    }
}
