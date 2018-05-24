<?php

declare(strict_types=1);

namespace Adlogix\EventScheduler\Exception;

use Exception;

/**
 * @author Toni Van de Voorde <toni@adlogix.eu>
 */
final class NotScheduledEventException
    extends \RuntimeException
    implements ExceptionInterface
{
    public static function create(Exception $previous = null) : self
    {
        return new self('EventInterface is not scheduled', 0, $previous);
    }
}
