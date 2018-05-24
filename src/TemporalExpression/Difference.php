<?php

declare(strict_types=1);

namespace Adlogix\EventScheduler\TemporalExpression;

use DateTimeInterface;

/**
 * @author Toni Van de Voorde <toni@adlogix.eu>
 */
final class Difference implements TemporalExpressionInterface
{
    /**
     * @var TemporalExpressionInterface
     */
    protected $included;

    /**
     * @var TemporalExpressionInterface
     */
    protected $excluded;

    /**
     * @param TemporalExpressionInterface $included
     * @param TemporalExpressionInterface $excluded
     */
    public function __construct(
        TemporalExpressionInterface $included,
        TemporalExpressionInterface $excluded
    ) {
        $this->included = $included;
        $this->excluded = $excluded;
    }

    /**
     * {@inheritdoc}
     */
    public function includes(DateTimeInterface $date): bool
    {
        return $this->included->includes($date) && !$this->excluded->includes($date);
    }
}
