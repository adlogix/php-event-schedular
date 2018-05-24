<?php

declare(strict_types=1);

namespace Adlogix\EventScheduler\TemporalExpression;

use DateTimeInterface;

/**
 * @author Toni Van de Voorde <toni@adlogix.eu>
 */
final class From implements TemporalExpressionInterface
{
    /**
     * @var DateTimeInterface
     */
    protected $date;

    /**
     * @param DateTimeInterface $date
     */
    public function __construct(DateTimeInterface $date)
    {
        $this->date = $date;
    }

    /**
     * {@inheritdoc}
     */
    public function includes(DateTimeInterface $date): bool
    {
        return $date >= $this->date;
    }
}
