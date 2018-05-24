<?php

declare(strict_types=1);

namespace Adlogix\EventScheduler;

use Adlogix\EventScheduler\TemporalExpression\TemporalExpressionInterface;
use DateTimeInterface;

/**
 * @author Toni Van de Voorde <toni@adlogix.eu>
 */
final class SchedulableEvent implements Occurrable
{
    /**
     * @var EventInterface
     */
    protected $event;

    /**
     * @var TemporalExpressionInterface
     */
    protected $temporalExpression;

    /**
     * @param EventInterface              $event
     * @param TemporalExpressionInterface $temporalExpression
     */
    public function __construct(EventInterface $event, TemporalExpressionInterface $temporalExpression)
    {
        $this->event = $event;
        $this->temporalExpression = $temporalExpression;
    }

    /**
     * @return EventInterface
     */
    public function event(): EventInterface
    {
        return $this->event;
    }

    /**
     * @return TemporalExpressionInterface
     */
    public function temporalExpression(): TemporalExpressionInterface
    {
        return $this->temporalExpression;
    }

    /**
     * {@inheritdoc}
     */
    public function isOccurring(EventInterface $event, DateTimeInterface $date): bool
    {
        return $this->event->equals($event) && $this->temporalExpression->includes($date);
    }
}
