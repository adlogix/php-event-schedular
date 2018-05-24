<?php

declare(strict_types=1);

namespace Adlogix\EventScheduler\TemporalExpression;

use Adlogix\EventScheduler\ValueObject\WeekDay;
use DateTimeInterface;

/**
 * @author Toni Van de Voorde <toni@adlogix.eu>
 */
final class DayInWeek implements TemporalExpressionInterface
{
    /**
     * @var WeekDay
     */
    protected $day;

    /**
     * @param WeekDay $day
     */
    private function __construct(WeekDay $day)
    {
        $this->day = $day;
    }

    /**
     * {@inheritdoc}
     */
    public function includes(DateTimeInterface $date): bool
    {
        return $this->day->equals(WeekDay::fromDateTime($date));
    }

    /**
     * @return DayInWeek
     */
    public static function monday(): self
    {
        return new self(WeekDay::monday());
    }

    /**
     * @return DayInWeek
     */
    public static function tuesday(): self
    {
        return new self(WeekDay::tuesday());
    }

    /**
     * @return DayInWeek
     */
    public static function wednesday(): self
    {
        return new self(WeekDay::wednesday());
    }

    /**
     * @return DayInWeek
     */
    public static function thursday(): self
    {
        return new self(WeekDay::thursday());
    }

    /**
     * @return DayInWeek
     */
    public static function friday(): self
    {
        return new self(WeekDay::friday());
    }

    /**
     * @return DayInWeek
     */
    public static function saturday(): self
    {
        return new self(WeekDay::saturday());
    }

    /**
     * @return DayInWeek
     */
    public static function sunday(): self
    {
        return new self(WeekDay::sunday());
    }
}
