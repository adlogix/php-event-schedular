<?php

declare(strict_types=1);

namespace Adlogix\EventScheduler;

use Countable;
use Iterator;
use SplObjectStorage;

/**
 * @author Toni Van de Voorde <toni@adlogix.eu>
 */
final class SchedulableEventCollection implements Countable, Iterator
{
    /**
     * @var SplObjectStorage|SchedulableEvent[]
     */
    private $events;

    /**
     * @param array $events
     */
    public function __construct(array $events = [])
    {
        $this->events = new SplObjectStorage;

        foreach ($events as $event) {
            $this->add($event);
        }
    }

    /**
     * @param SchedulableEvent $schedulableEvent
     */
    public function add(SchedulableEvent $schedulableEvent)
    {
        $this->events->attach($schedulableEvent);
    }

    /**
     * @param SchedulableEvent $schedulableEvent
     * @return bool
     */
    public function contains(SchedulableEvent $schedulableEvent): bool
    {
        return $this->events->contains($schedulableEvent);
    }

    /**
     * @param SchedulableEvent $schedulableEvent
     */
    public function remove(SchedulableEvent $schedulableEvent)
    {
        if (!$this->events->contains($schedulableEvent)) {
            throw Exception\NotScheduledEventException::create();
        }

        $this->events->detach($schedulableEvent);
    }

    /**
     * @param EventInterface $event
     * @return SchedulableEventCollection
     */
    public function filterByEvent(EventInterface $event): self
    {
        $filteredEvents = array_filter(
            iterator_to_array($this->events),
            function (SchedulableEvent $scheduledEvent) use ($event) {
                return $event->equals($scheduledEvent->event());
            }
        );

        return new self($filteredEvents);
    }

    /**
     * {@inheritdoc}
     */
    public function current(): SchedulableEvent
    {
        return $this->events->current();
    }

    /**
     * {@inheritdoc}
     */
    public function next()
    {
        $this->events->next();
    }

    /**
     * {@inheritdoc}
     */
    public function key(): int
    {
        return $this->events->key();
    }

    /**
     * {@inheritdoc}
     */
    public function valid(): bool
    {
        return $this->events->valid();
    }

    /**
     * {@inheritdoc}
     */
    public function rewind()
    {
        $this->events->rewind();
    }

    /**
     * {@inheritdoc}
     */
    public function count(): int
    {
        return $this->events->count();
    }
}
