<?php

declare(strict_types=1);

namespace Adlogix\EventScheduler;

use DateTimeInterface;

/**
 * @author Toni Van de Voorde <toni@adlogix.eu>
 */
interface Occurrable
{
    public function isOccurring(EventInterface $event, DateTimeInterface $date): bool;
}
