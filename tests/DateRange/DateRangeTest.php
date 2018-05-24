<?php

declare(strict_types=1);

namespace Adlogix\EventSchedulerTest\DateRange;

use DateTimeImmutable;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Adlogix\EventScheduler\DateRange\DateRange;

/**
 * @author Toni Van de Voorde <toni@adlogix.eu>
 */
class DateRangeTest extends TestCase
{
    /**
     * @test
     */
    public function constructor_GivenStartDateOlderThanEndDate_ShouldThrowException()
    {
        $this->expectException(InvalidArgumentException::class);
        new DateRange(
            new DateTimeImmutable('2015-03-05'),
            new DateTimeImmutable('2015-03-01')
        );
    }
}
