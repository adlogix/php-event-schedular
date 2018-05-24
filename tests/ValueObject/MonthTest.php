<?php

declare(strict_types=1);

namespace Adlogix\EventSchedulerTest\ValueObject;

use PHPUnit\Framework\TestCase;
use Adlogix\EventScheduler\ValueObject\Month;

/**
 * @author Toni Van de Voorde <toni@adlogix.eu>
 */
class MonthTest extends TestCase
{
    /**
     * @return array
     */
    public function dataProvider_number(): array
    {
        return [
            [1, Month::january()],
            [2, Month::february()],
            [3, Month::march()],
            [4, Month::april()],
            [5, Month::may()],
            [6, Month::june()],
            [7, Month::july()],
            [8, Month::august()],
            [9, Month::september()],
            [10, Month::october()],
            [11, Month::november()],
            [12, Month::december()]
        ];
    }

    /**
     * @test
     * @dataProvider dataProvider_number
     * @param int   $number
     * @param Month $month
     */
    public function fromNumber_GivenScalarValue_ShouldConstructMonthWithRelatedName(int $number, Month $month)
    {
        $this->assertTrue($month->equals(Month::fromNumber($number)));
    }

    public function dataProvider_dateTimeInterface()
    {
        return [
            [new \DateTimeImmutable('2018-03-20'), Month::march()],
            [new \DateTime('2018-07-20'), Month::july()],
        ];
    }

    /**
     * @test
     * @dataProvider dataProvider_dateTimeInterface
     * @param \DateTimeInterface $dateTime
     * @param Month              $expectedMonth
     */
    public function fromDateTime_GivenDateTimeInterfaceValue_ShouldConstructMonth(
        \DateTimeInterface $dateTime,
        Month $expectedMonth
    ) {
        $this->assertEquals($expectedMonth, Month::fromDateTime($dateTime));
    }
}
