<?php

declare(strict_types=1);

namespace Adlogix\EventScheduler\TemporalExpression\Collection;

use Adlogix\EventScheduler\TemporalExpression\TemporalExpressionInterface;
use DateTimeInterface;

/**
 * @author Toni Van de Voorde <toni@adlogix.eu>
 */
abstract class AbstractCollection implements TemporalExpressionInterface
{
    /**
     * @var array|TemporalExpressionInterface[]
     */
    protected $elements;

    /**
     * @param TemporalExpressionInterface $temporalExpression
     * @return AbstractCollection
     */
    public function addElement(TemporalExpressionInterface $temporalExpression): self
    {
        $this->elements[] = $temporalExpression;
        return $this;
    }

    /**
     * @param DateTimeInterface $date
     * @return bool
     */
    abstract public function includes(DateTimeInterface $date): bool;
}
