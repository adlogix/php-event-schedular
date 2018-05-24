<?php

declare(strict_types=1);

namespace Adlogix\EventScheduler;

/**
 * @author Toni Van de Voorde <toni@adlogix.eu>
 */
interface EventInterface
{
    /**
     * @param $compare
     * @return bool
     */
    public function equals($compare): bool;
}
