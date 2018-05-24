<?php

declare(strict_types=1);

namespace Adlogix\EventScheduler\TemporalExpression;

use Adlogix\EventScheduler\ValueObject\Month;
use DateTimeInterface;

/**
 * @author Toni Van de Voorde <toni@adlogix.eu>
 */
final class MonthInYear implements TemporalExpressionInterface
{
    /**
     * @var Month
     */
    protected $month;

    /**
     * @param Month $month
     */
    private function __construct(Month $month)
    {
        $this->month = $month;
    }

    /**
     * {@inheritdoc}
     */
    public function includes(DateTimeInterface $date): bool
    {
        return $this->month->equals(Month::fromDateTime($date));
    }

    /**
     * @return MonthInYear
     */
    public static function january(): self
    {
        return new self(Month::january());
    }

    /**
     * @return MonthInYear
     */
    public static function february(): self
    {
        return new self(Month::february());
    }

    /**
     * @return MonthInYear
     */
    public static function march(): self
    {
        return new self(Month::march());
    }

    /**
     * @return MonthInYear
     */
    public static function april(): self
    {
        return new self(Month::april());
    }

    /**
     * @return MonthInYear
     */
    public static function may(): self
    {
        return new self(Month::may());
    }

    /**
     * @return MonthInYear
     */
    public static function june(): self
    {
        return new self(Month::june());
    }

    /**
     * @return MonthInYear
     */
    public static function july(): self
    {
        return new self(Month::july());
    }

    /**
     * @return MonthInYear
     */
    public static function august(): self
    {
        return new self(Month::august());
    }

    /**
     * @return MonthInYear
     */
    public static function september(): self
    {
        return new self(Month::september());
    }

    /**
     * @return MonthInYear
     */
    public static function october(): self
    {
        return new self(Month::october());
    }

    /**
     * @return MonthInYear
     */
    public static function november(): self
    {
        return new self(Month::november());
    }

    /**
     * @return MonthInYear
     */
    public static function december(): self
    {
        return new self(Month::december());
    }
}
