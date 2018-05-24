<?php

declare(strict_types=1);

namespace Adlogix\EventScheduler\TemporalExpression;

use DateTimeInterface;

/**
 * @author Toni Van de Voorde <toni@adlogix.eu>
 */
interface TemporalExpressionInterface
{
    /**
     * @param DateTimeInterface $date
     * @return bool
     */
    public function includes(DateTimeInterface $date): bool;
}
