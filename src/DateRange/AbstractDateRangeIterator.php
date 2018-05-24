<?php

declare(strict_types=1);

namespace Adlogix\EventScheduler\DateRange;

use DateInterval;
use DateTimeImmutable;
use Iterator;

/**
 * @author Toni Van de Voorde <toni@adlogix.eu>
 */
abstract class AbstractDateRangeIterator implements Iterator
{
    /**
     * @var DateRange
     */
    protected $dateRange;

    /**
     * @var DateInterval
     */
    protected $interval;

    /**
     * @var int
     */
    protected $key = 0;

    /**
     * @var DateTimeImmutable
     */
    protected $current;

    /**
     * @param DateRange         $dateRange
     * @param DateInterval|null $interval
     */
    public function __construct(DateRange $dateRange, DateInterval $interval = null)
    {
        $this->dateRange = $dateRange;
        $this->interval = $interval ?: new DateInterval('P1D');
    }

    /**
     * @return DateTimeImmutable
     */
    public function current(): DateTimeImmutable
    {
        return $this->current;
    }

    /**
     * @return int
     */
    public function key(): int
    {
        return $this->key;
    }

    /**
     * @return bool
     */
    public function valid(): bool
    {
        return $this->current >= $this->dateRange->startDate()
            && $this->current <= $this->dateRange->endDate();
    }
}
