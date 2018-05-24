<?php

declare(strict_types=1);

namespace Adlogix\EventScheduler\TemporalExpression;

use DateTimeInterface;

/**
 * @author Toni Van de Voorde <toni@adlogix.eu>
 */
final class LeapYear implements TemporalExpressionInterface
{
    /**
     * {@inheritdoc}
     */
    public function includes(DateTimeInterface $date): bool
    {
        return $date->format('L') == 1;
    }
}
