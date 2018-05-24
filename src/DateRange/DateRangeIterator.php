<?php

declare(strict_types=1);

namespace Adlogix\EventScheduler\DateRange;

use DateInterval;

/**
 * @author Toni Van de Voorde <toni@adlogix.eu>
 */
final class DateRangeIterator extends AbstractDateRangeIterator
{
    /**
     * @param DateRange         $dateRange
     * @param DateInterval|null $interval
     */
    public function __construct(DateRange $dateRange, DateInterval $interval = null)
    {
        parent::__construct($dateRange, $interval);
        $this->current = $dateRange->startDate();
    }

    public function next()
    {
        $this->current = $this->current->add($this->interval);
        $this->key++;
    }

    public function rewind()
    {
        $this->key = 0;
        $this->current = $this->dateRange->startDate();
    }
}
