<?php

declare(strict_types=1);

namespace Adlogix\EventScheduler\ValueObject;

use DateTime;
use Webmozart\Assert\Assert;

/**
 * @author Toni Van de Voorde <toni@adlogix.eu>
 */
final class Week
{
    /**
     * @var int
     */
    private $value;

    /**
     * @param int $value
     */
    public function __construct(int $value)
    {
        Assert::range($value, 1, 53);
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
     * @param Week $week
     * @return bool
     */
    public function equals(Week $week): bool
    {
        return $this->value === $week->value();
    }

    /**
     * @return Week
     */
    public static function now(): self
    {
        $now = new DateTime('now');

        return self::fromDateTime($now);
    }

    /**
     * @param \DateTimeInterface $dateTime
     * @return Week
     */
    public static function fromDateTime(\DateTimeInterface $dateTime): self
    {
        $week = \intval($dateTime->format('W'));

        return new self($week);
    }
}
