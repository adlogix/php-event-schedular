<?php

declare(strict_types=1);

namespace Adlogix\EventScheduler\ValueObject;

use DateTimeInterface;
use Webmozart\Assert\Assert;

/**
 * @author Toni Van de Voorde <toni@adlogix.eu>
 */
final class WeekDay
{
    /**
     * @var int
     */
    private $number;

    /**
     * @param int $number
     */
    private function __construct(int $number)
    {
        Assert::range($number, 1, 7);
        $this->number = $number;
    }

    /**
     * @return int
     */
    public function number(): int
    {
        return $this->number;
    }

    /**
     * @param WeekDay $weekDay
     * @return bool
     */
    public function equals(WeekDay $weekDay): bool
    {
        return $this->number === $weekDay->number();
    }

    /**
     * @return WeekDay
     */
    public static function monday(): self
    {
        return new self(1);
    }

    /**
     * @return WeekDay
     */
    public static function tuesday(): self
    {
        return new self(2);
    }

    /**
     * @return WeekDay
     */
    public static function wednesday(): self
    {
        return new self(3);
    }

    /**
     * @return WeekDay
     */
    public static function thursday(): self
    {
        return new self(4);
    }

    /**
     * @return WeekDay
     */
    public static function friday(): self
    {
        return new self(5);
    }

    /**
     * @return WeekDay
     */
    public static function saturday(): self
    {
        return new self(6);
    }

    /**
     * @return WeekDay
     */
    public static function sunday(): self
    {
        return new self(7);
    }

    /**
     * @param DateTimeInterface $dateTime
     * @return WeekDay
     */
    final public static function fromDateTime(DateTimeInterface $dateTime): self
    {
        return WeekDay::fromNumber((int)$dateTime->format('N'));
    }

    /**
     * Returns a WeekDay instance from a numeric value. The representation is according to ISO-8601.
     *
     * @param int $number
     * @return WeekDay
     */
    final public static function fromNumber(int $number): self
    {
        switch ($number) {
            case 1:
            case 2:
            case 3:
            case 4:
            case 5:
            case 6:
            case 7:
                return new self($number);
        }

        throw new \InvalidArgumentException(sprintf('Given number %d is an invalid WeekDay number', $number));
    }
}
