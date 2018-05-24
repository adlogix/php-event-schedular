<?php

declare(strict_types=1);

namespace Adlogix\EventScheduler\ValueObject;

use DateTimeInterface;

/**
 * @author Toni Van de Voorde <toni@adlogix.eu>
 */
final class Month
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
        $this->number = $number;
    }

    /**
     * @return int
     */
    public function number()
    {
        return $this->number;
    }

    /**
     * @param Month $month
     * @return bool
     */
    public function equals(Month $month): bool
    {
        return $this->number === $month->number();
    }

    /**
     * @return Month
     */
    final public static function january(): self
    {
        return new self(1);
    }

    /**
     * @return Month
     */
    final public static function february(): self
    {
        return new self(2);
    }

    /**
     * @return Month
     */
    final public static function march(): self
    {
        return new self(3);
    }

    /**
     * @return Month
     */
    final public static function april(): self
    {
        return new self(4);
    }

    /**
     * @return Month
     */
    final public static function may(): self
    {
        return new self(5);
    }

    /**
     * @return Month
     */
    final public static function june(): self
    {
        return new self(6);
    }

    /**
     * @return Month
     */
    final public static function july(): self
    {
        return new self(7);
    }

    /**
     * @return Month
     */
    final public static function august(): self
    {
        return new self(8);
    }

    /**
     * @return Month
     */
    final public static function september(): self
    {
        return new self(9);
    }

    /**
     * @return Month
     */
    final public static function october(): self
    {
        return new self(10);
    }

    /**
     * @return Month
     */
    final public static function november(): self
    {
        return new self(11);
    }

    /**
     * @return Month
     */
    final public static function december(): self
    {
        return new self(12);
    }

    /**
     * @param DateTimeInterface $dateTime
     * @return Month
     */
    final public static function fromDateTime(DateTimeInterface $dateTime): self
    {
        return Month::fromNumber((int)$dateTime->format('n'));
    }

    /**
     * @param int $number
     * @return Month
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
            case 8:
            case 9:
            case 10:
            case 11:
            case 12:
                return new self($number);
        }

        throw new \InvalidArgumentException(sprintf('Given number %d is an invalid Month number', $number));
    }
}
