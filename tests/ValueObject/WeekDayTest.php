<?php

declare(strict_types=1);

namespace Adlogix\EventSchedulerTest\ValueObject;

use PHPUnit\Framework\TestCase;
use Adlogix\EventScheduler\ValueObject\WeekDay;

final class WeekDayTest extends TestCase
{
    public function getDataProvider()
    {
        return [
            [1, WeekDay::monday()],
            [2, WeekDay::tuesday()],
            [3, WeekDay::wednesday()],
            [4, WeekDay::thursday()],
            [5, WeekDay::friday()],
            [6, WeekDay::saturday()],
            [7, WeekDay::sunday()],
        ];
    }

    /**
     * @test
     * @dataProvider getDataProvider
     * @param int     $numericValue
     * @param WeekDay $weekDay
     */
    public function fromNativeOrNumericValue_GivenScalarValue_ShouldConstructWeekDayWithRelatedName(
        int $numericValue,
        WeekDay $weekDay
    ) {
        $this->assertTrue($weekDay->equals(WeekDay::fromNumber($numericValue)));
    }
}
