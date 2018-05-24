<?php

declare(strict_types=1);

namespace Adlogix\EventScheduler\TemporalExpression;

use Adlogix\EventScheduler\ValueObject\Week;
use DateTimeInterface;

/**
 * @author Toni Van de Voorde <toni@adlogix.eu>
 */
final class WeekInYear implements TemporalExpressionInterface
{
    /**
     * @var Week
     */
    protected $week;

    /**
     * @param int $week
     */
    public function __construct(int $week)
    {
        $this->week = new Week($week);
    }

    /**
     * {@inheritdoc}
     */
    public function includes(DateTimeInterface $date): bool
    {
        return $this->week->equals(Week::fromDateTime($date));
    }
}
