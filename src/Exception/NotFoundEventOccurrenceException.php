<?php

declare(strict_types=1);

namespace Adlogix\EventScheduler\Exception;

use Exception;

/**
 * @author Toni Van de Voorde <toni@adlogix.eu>
 */
final class NotFoundEventOccurrenceException
    extends \RuntimeException
    implements ExceptionInterface
{
    public static function create(Exception $previous = null) : self
    {
        return new self('EventInterface occurence not found', 0, $previous);
    }
}
