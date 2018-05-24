<?php

declare(strict_types=1);

namespace Adlogix\EventScheduler\DateRange;

use DateTimeImmutable;
use DateTimeInterface;
use InvalidArgumentException;

/**
 * @author Toni Van de Voorde <toni@adlogix.eu>
 */
final class DateRange
{
    /**
     * @var DateTimeImmutable
     */
    protected $startDate;

    /**
     * @var DateTimeImmutable
     */
    protected $endDate;

    /**
     * @param DateTimeInterface $startDate
     * @param DateTimeInterface $endDate
     */
    public function __construct(DateTimeInterface $startDate, DateTimeInterface $endDate)
    {
        if ($startDate > $endDate) {
            throw new InvalidArgumentException('The start date must be more recent that end date');
        }

        $this->startDate = $this->makeImmutable($startDate);
        $this->endDate = $this->makeImmutable($endDate);
    }

    /**
     * @param DateTimeInterface $date
     * @return DateTimeImmutable
     */
    private function makeImmutable(DateTimeInterface $date): DateTimeImmutable
    {
        return ($date instanceof DateTimeImmutable)
            ? $date
            : DateTimeImmutable::createFromMutable($date);
    }

    /**
     * @return DateTimeImmutable
     */
    public function startDate(): DateTimeImmutable
    {
        return $this->startDate;
    }

    /**
     * @return DateTimeImmutable
     */
    public function endDate(): DateTimeImmutable
    {
        return $this->endDate;
    }
}
