<?php

declare(strict_types=1);

namespace Adlogix\EventScheduler\TemporalExpression\Collection;

use DateTimeInterface;

/**
 * @author Toni Van de Voorde <toni@adlogix.eu>
 */
final class Union extends AbstractCollection
{
    /**
     * {@inheritdoc}
     */
    public function includes(DateTimeInterface $date) : bool
    {
        foreach ($this->elements as $element) {
            if ($element->includes($date)) {
                return true;
            }
        }

        return false;
    }
}
