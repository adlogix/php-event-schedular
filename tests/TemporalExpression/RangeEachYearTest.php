<?php

declare(strict_types=1);

namespace Adlogix\EventSchedulerTest\TemporalExpression;

use DateTime;
use PHPUnit\Framework\TestCase;
use Adlogix\EventScheduler\TemporalExpression\RangeEachYear;
use Adlogix\EventScheduler\ValueObject\Month;
use Adlogix\EventScheduler\ValueObject\MonthDay;

/**
 * @author Toni Van de Voorde <toni@adlogix.eu>
 */
final class RangeEachYearTest extends TestCase
{
    public function getDataProvider()
    {
        return [
            [Month::january(), Month::march(), null, null, new DateTime('2015-02-05'), true],
            [Month::january(), Month::march(), new MonthDay(10), new MonthDay(20), new DateTime('2015-01-05'), false],
            [Month::january(), Month::march(), new MonthDay(10), new MonthDay(20), new DateTime('2015-02-05'), true],
            [Month::january(), Month::march(), new MonthDay(10), new MonthDay(20), new DateTime('2015-03-05'), true],
            [Month::january(), Month::march(), new MonthDay(10), new MonthDay(20), new DateTime('2015-03-25'), false],
            [Month::december(), Month::april(), new MonthDay(20), new MonthDay(10), new DateTime('2015-03-15'), true],
        ];
    }

    /**
     * @test
     * @dataProvider getDataProvider
     * @param Month              $startMonth
     * @param Month              $endMonth
     * @param MonthDay           $startDay
     * @param MonthDay           $endDay
     * @param \DateTimeInterface $date
     * @param bool               $expected
     */
    public function includes_GivenDatesFromDataProvider_ShouldMatchExpectedValue(
        Month $startMonth,
        Month $endMonth,
        MonthDay $startDay = null,
        MonthDay $endDay = null,
        \DateTimeInterface $date,
        bool $expected
    ) {
        $expr = new RangeEachYear($startMonth, $endMonth, $startDay, $endDay);

        $isIncluded = $expr->includes($date);

        $this->assertSame($expected, $isIncluded);
    }
}
