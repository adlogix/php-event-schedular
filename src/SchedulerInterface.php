<?php

declare(strict_types=1);

namespace Adlogix\EventScheduler;

use Adlogix\EventScheduler\DateRange\DateRange;
use Adlogix\EventScheduler\TemporalExpression\TemporalExpressionInterface;
use DateTimeImmutable;
use DateTimeInterface;
use Traversable;

/**
 * @author Toni Van de Voorde <toni@adlogix.eu>
 */
interface SchedulerInterface extends Occurrable
{
    /**
     * @param EventInterface              $event
     * @param TemporalExpressionInterface $temporalExpression
     * @return SchedulableEvent
     */
    public function schedule(
        EventInterface $event,
        TemporalExpressionInterface $temporalExpression
    ): SchedulableEvent;

    /**
     * @param SchedulableEvent $schedulableEvent
     */
    public function cancel(SchedulableEvent $schedulableEvent): void;

    /**
     * @param EventInterface $event
     * @return bool
     */
    public function isScheduled(EventInterface $event): bool;

    /**
     * @param DateTimeInterface $date
     * @return Traversable
     */
    public function eventsForDate(DateTimeInterface $date): Traversable;

    /**
     * @param EventInterface $event
     * @param DateRange      $range
     * @return DateTimeImmutable[]|Traversable
     */
    public function dates(EventInterface $event, DateRange $range): Traversable;

    /**
     * @param EventInterface $event
     * @param DateRange      $range
     * @return DateTimeImmutable
     */
    public function nextOccurrence(
        EventInterface $event,
        DateRange $range
    ): DateTimeImmutable;

    /**
     * @param EventInterface $event
     * @param DateRange      $range
     * @return DateTimeImmutable
     */
    public function previousOccurrence(
        EventInterface $event,
        DateRange $range
    ): DateTimeImmutable;
}
