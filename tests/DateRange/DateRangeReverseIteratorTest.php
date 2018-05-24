<?php

declare(strict_types=1);

namespace Adlogix\EventSchedulerTest\DateRange;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Adlogix\EventScheduler\DateRange\DateRange;
use Adlogix\EventScheduler\DateRange\DateRangeReverseIterator;

class DateRangeReverseIteratorTest extends TestCase
{
    protected $expectedDates = [];

    public function setUp()
    {
        $this->expectedDates = [
            new DateTimeImmutable('2015-03-05'),
            new DateTimeImmutable('2015-03-04'),
            new DateTimeImmutable('2015-03-03'),
            new DateTimeImmutable('2015-03-02'),
            new DateTimeImmutable('2015-03-01'),
        ];
    }

    /**
     * @test
     */
    public function dateRange_ShouldIterate()
    {
        $startDate = new DateTimeImmutable('2015-03-01');
        $endDate   = new DateTimeImmutable('2015-03-05');

        $range     = new DateRange($startDate, $endDate);
        $iterator  = new DateRangeReverseIterator($range);

        foreach ($iterator as $key => $date) {
            $this->assertEquals($this->expectedDates[$key], $date);
        }
    }
}
