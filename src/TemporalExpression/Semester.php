<?php

declare(strict_types=1);

namespace Adlogix\EventScheduler\TemporalExpression;

use Adlogix\EventScheduler\ValueObject\Semester as SemesterValueObject;
use DateTimeInterface;

/**
 * @author Toni Van de Voorde <toni@adlogix.eu>
 */
final class Semester implements TemporalExpressionInterface
{
    /**
     * @var SemesterValueObject
     */
    protected $semester;

    /**
     * @param SemesterValueObject $semester
     */
    private function __construct(SemesterValueObject $semester)
    {
        $this->semester = $semester;
    }

    /**
     * @return Semester
     */
    public static function first(): self
    {
        return new self(SemesterValueObject::first());
    }

    /**
     * @return Semester
     */
    public static function second(): self
    {
        return new self(SemesterValueObject::second());
    }

    /**
     * {@inheritdoc}
     */
    public function includes(DateTimeInterface $dateTime): bool
    {
        return $this->semester->equals(SemesterValueObject::fromDateTime($dateTime));
    }
}
