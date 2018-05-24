<?php

declare(strict_types=1);

namespace Adlogix\EventSchedulerTest\TemporalExpression;

use DateTime;
use PHPUnit\Framework\TestCase;
use Adlogix\EventScheduler\TemporalExpression\DayInMonth;

class DayInMonthTest extends TestCase
{
    /**
     * @test
     * @expectedException \TypeError
     */
    public function constructor_GivenInvalidDayInMonthType_ShouldThrowTypeErrorException()
    {
        new DayInMonth('invalid');
    }

    public function getInvalidDayDataProvider()
    {
        return [
            [0],
            [32],
        ];
    }

    /**
     * @test
     * @dataProvider getInvalidDayDataProvider
     * @expectedException \Exception
     * @param int $day
     */
    public function constructor_GivenInvalidDay_ShouldThrowAnException(int $day)
    {
        new DayInMonth($day);
    }

    /**
     * @test
     */
    public function includes_GivenDateAtSameMonthDay_ShouldReturnTrue()
    {
        $date = new DateTime('2015-04-12');
        $expr = new DayInMonth(12);

        $isIncluded = $expr->includes($date);

        $this->assertThat($isIncluded, $this->isTrue());
    }

    /**
     * @test
     */
    public function includes_GivenDateAtDifferentMonthDay_ShouldReturnFalse()
    {
        $date = new DateTime('2015-04-12');
        $expr = new DayInMonth(14);

        $isIncluded = $expr->includes($date);

        $this->assertThat($isIncluded, $this->isFalse());
    }
}
