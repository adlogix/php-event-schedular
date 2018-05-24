<?php

declare(strict_types=1);

namespace Adlogix\EventSchedulerTest\TemporalExpression;

use DateTime;
use PHPUnit\Framework\TestCase;
use Adlogix\EventScheduler\TemporalExpression\MonthInYear;
use Adlogix\EventScheduler\ValueObject\Month;

/**
 * @author Toni Van de Voorde <toni@adlogix.eu>
 */
class MonthInYearTest extends TestCase
{
    /**
     * @test
     */
    public function includes_GivenDateAtSameMonth_ShouldReturnTrue()
    {
        $date = new DateTime('2015-04-10');
        $expr = MonthInYear::april();

        $isIncluded = $expr->includes($date);

        $this->assertThat($isIncluded, $this->isTrue());
    }

    /**
     * @test
     */
    public function includes_GivenDateAtDifferentMonth_ShouldReturnFalse()
    {
        $date = new DateTime('2015-04-10');
        $expr = MonthInYear::november();

        $isIncluded = $expr->includes($date);

        $this->assertThat($isIncluded, $this->isFalse());
    }
}
