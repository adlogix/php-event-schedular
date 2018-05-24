<?php

declare(strict_types=1);

namespace Adlogix\EventSchedulerTest\Fixtures\TemporalExpression;

use DateTimeInterface;
use Adlogix\EventScheduler\TemporalExpression\TemporalExpressionInterface;

/**
 * @author Toni Van de Voorde <toni@adlogix.eu>
 */
final class NeverOccurringTemporalExpression implements TemporalExpressionInterface
{
    /**
     * {@inheritdoc}
     */
    public function includes(DateTimeInterface $date): bool
    {
        return false;
    }
}
