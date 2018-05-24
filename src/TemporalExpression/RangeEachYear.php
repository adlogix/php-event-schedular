<?php

declare(strict_types=1);

namespace Adlogix\EventScheduler\TemporalExpression;

use Adlogix\EventScheduler\ValueObject\Month;
use Adlogix\EventScheduler\ValueObject\MonthDay;
use DateTimeInterface;

/**
 * @author Toni Van de Voorde <toni@adlogix.eu>
 */
final class RangeEachYear implements TemporalExpressionInterface
{
    /**
     * @var Month
     */
    protected $startMonth;

    /**
     * @var Month
     */
    protected $endMonth;

    /**
     * @var MonthDay
     */
    protected $startDay;

    /**
     * @var MonthDay
     */
    protected $endDay;

    /**
     * @param Month         $startMonth
     * @param Month         $endMonth
     * @param MonthDay|null $startDay
     * @param MonthDay|null $endDay
     */
    public function __construct(
        Month $startMonth,
        Month $endMonth,
        MonthDay $startDay = null,
        MonthDay $endDay = null
    ) {
        $this->startMonth = $startMonth;
        $this->endMonth = $endMonth;

        $this->startDay = $startDay;
        $this->endDay = $endDay;
    }

    /**
     * {@inheritdoc}
     */
    public function includes(DateTimeInterface $date): bool
    {
        return $this->monthsInclude($date)
            || $this->startMonthIncludes($date)
            || $this->endMonthIncludes($date);
    }

    /**
     * @param DateTimeInterface $date
     * @return bool
     */
    private function monthsInclude(DateTimeInterface $date): bool
    {
        $month = Month::fromDateTime($date);
        $ordinalMonth = $month->number();

        $ordinalStartMonth = $this->startMonth->number();
        $ordinalEndMonth = $this->endMonth->number();

        if ($ordinalStartMonth <= $ordinalEndMonth) {
            return ($ordinalMonth > $ordinalStartMonth && $ordinalMonth < $ordinalEndMonth);
        } else {
            return ($ordinalMonth > $ordinalStartMonth || $ordinalMonth < $ordinalEndMonth);
        }
    }

    /**
     * @param DateTimeInterface $date
     * @return bool
     */
    private function startMonthIncludes(DateTimeInterface $date): bool
    {
        if (!$this->startMonth->equals(Month::fromDateTime($date))) {
            return false;
        }

        if (!$this->startDay) {
            return true;
        }

        return $this->startDay->lte(MonthDay::fromDateTime($date));
    }

    /**
     * @param DateTimeInterface $date
     * @return bool
     */
    private function endMonthIncludes(DateTimeInterface $date): bool
    {
        if (!$this->endMonth->equals(Month::fromDateTime($date))) {
            return false;
        }

        if (!$this->endDay) {
            return true;
        }

        return $this->endDay->gte(MonthDay::fromDateTime($date));
    }
}
