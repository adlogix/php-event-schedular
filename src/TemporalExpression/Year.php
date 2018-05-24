<?php

declare(strict_types=1);

namespace Adlogix\EventScheduler\TemporalExpression;

use Adlogix\EventScheduler\ValueObject\Year as YearValueObject;
use DateTimeInterface;

/**
 * @author Toni Van de Voorde <toni@adlogix.eu>
 */
final class Year implements TemporalExpressionInterface
{
    /**
     * @var YearValueObject
     */
    protected $year;

    /**
     * @param int $year
     */
    public function __construct(int $year)
    {
        $this->year = new YearValueObject($year);
    }

    /**
     * {@inheritdoc}
     */
    public function includes(DateTimeInterface $date): bool
    {
        return $this->year->equals(YearValueObject::fromDateTime($date));
    }
}
