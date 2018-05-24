<?php

declare(strict_types=1);

namespace Adlogix\EventScheduler\DateRange;

use DateInterval;

/**
 * @author Toni Van de Voorde <toni@adlogix.eu>
 */
final class DateRangeReverseIterator extends AbstractDateRangeIterator
{
    /**
     * {@inheritdoc}
     */
    public function __construct(DateRange $dateRange, DateInterval $interval = null)
    {
        parent::__construct($dateRange, $interval);
        $this->current = $dateRange->endDate();
    }

    /**
     * {@inheritdoc}
     */
    public function next(): void
    {
        $this->current = $this->current->sub($this->interval);
        $this->key++;
    }

    /**
     * {@inheritdoc}
     */
    public function rewind(): void
    {
        $this->key = 0;
        $this->current = $this->dateRange->endDate();
    }
}
