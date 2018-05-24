<?php

declare(strict_types=1);

namespace Adlogix\EventScheduler;

use Adlogix\EventScheduler\DateRange\DateRange;
use Adlogix\EventScheduler\DateRange\DateRangeIterator;
use Adlogix\EventScheduler\DateRange\DateRangeReverseIterator;
use Adlogix\EventScheduler\TemporalExpression\TemporalExpressionInterface;
use DateInterval;
use DateTimeImmutable;
use DateTimeInterface;
use Traversable;

/**
 * @author Toni Van de Voorde <toni@adlogix.eu>
 */
final class Scheduler implements SchedulerInterface
{
    /**
     * @var SchedulableEventCollection
     */
    private $scheduledEvents;

    public function __construct()
    {
        $this->scheduledEvents = new SchedulableEventCollection();
    }

    /**
     * {@inheritdoc}
     */
    public function schedule(
        EventInterface $event,
        TemporalExpressionInterface $temporalExpression
    ): SchedulableEvent {
        $schedulableEvent = new SchedulableEvent($event, $temporalExpression);
        $this->scheduledEvents->add($schedulableEvent);

        return $schedulableEvent;
    }

    /**
     * {@inheritdoc}
     */
    public function cancel(SchedulableEvent $schedulableEvent): void
    {
        $this->scheduledEvents->remove($schedulableEvent);
    }

    /**
     * {@inheritdoc}
     */
    public function isScheduled(EventInterface $event): bool
    {
        $scheduledEvents = $this->scheduledEvents->filterByEvent($event);

        return count($scheduledEvents) > 0;
    }

    /**
     * {@inheritdoc}
     */
    public function isOccurring(EventInterface $event, DateTimeInterface $date): bool
    {
        $scheduledEvents = $this->scheduledEvents->filterByEvent($event);
        foreach ($scheduledEvents as $scheduledEvent) {
            if ($scheduledEvent->isOccurring($event, $date)) {
                return true;
            }
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function eventsForDate(DateTimeInterface $date): Traversable
    {
        foreach ($this->scheduledEvents as $scheduledEvent) {
            $event = $scheduledEvent->event();
            if ($this->isOccurring($event, $date)) {
                yield $event;
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function dates(EventInterface $event, DateRange $range): Traversable
    {
        $iterator = $this->createDateRangeIterator($range);

        while ($iterator->valid()) {

            if ($this->isOccurring($event, $iterator->current())) {
                $foundDates = $iterator->current();
                yield $foundDates;
            }
            $iterator->next();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function nextOccurrence(
        EventInterface $event,
        DateRange $range
    ): DateTimeImmutable {
        return $this->findNextOccurrenceInIterator(
            $event,
            $this->createDateRangeIterator($range)
        );
    }

    /**
     * {@inheritdoc}
     */
    public function previousOccurrence(
        EventInterface $event,
        DateRange $range
    ): DateTimeImmutable {
        return $this->findNextOccurrenceInIterator(
            $event,
            $this->createDateRangeReverseIterator($range)
        );
    }

    /**
     * @param DateRange $range
     * @return DateRangeIterator
     * @throws \Exception
     */
    private function createDateRangeIterator(
        DateRange $range
    ): DateRangeIterator {
        return new DateRangeIterator($range, new DateInterval('P1D'));
    }

    /**
     * @param DateRange $range
     * @return DateRangeReverseIterator
     * @throws \Exception
     */
    private function createDateRangeReverseIterator(
        DateRange $range
    ): DateRangeReverseIterator {
        return new DateRangeReverseIterator($range, new DateInterval('P1D'));
    }

    /**
     * @param EventInterface $event
     * @param Traversable    $dates
     * @return DateTimeImmutable
     */
    private function findNextOccurrenceInIterator(EventInterface $event, Traversable $dates): DateTimeImmutable
    {
        foreach ($dates as $date) {
            if ($this->isOccurring($event, $date)) {
                return $date;
            }
        }

        throw Exception\NotFoundEventOccurrenceException::create();
    }
}
