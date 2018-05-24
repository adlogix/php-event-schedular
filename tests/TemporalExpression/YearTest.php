<?php

declare(strict_types=1);

namespace Adlogix\EventSchedulerTest\TemporalExpression;

use DateTime;
use PHPUnit\Framework\TestCase;
use Adlogix\EventScheduler\TemporalExpression\Year;

class YearTest extends TestCase
{
    /**
     * @test
     * @expectedException \TypeError
     */
    public function constructor_GivenInvalidYearType_ShouldThrowTypeErrorException()
    {
        new Year('invalid');
    }

    /**
     * @test
     */
    public function includes_GivenDateAtSameYear_ShouldReturnTrue()
    {
        $date = new DateTime('2015-04-10');
        $expr = new Year(2015);

        $isIncluded = $expr->includes($date);

        $this->assertThat($isIncluded, $this->isTrue());
    }

    /**
     * @test
     */
    public function includes_GivenDateAtDifferentYear_ShouldReturnFalse()
    {
        $date = new DateTime('2015-04-10');
        $expr = new Year(2016);

        $isIncluded = $expr->includes($date);

        $this->assertThat($isIncluded, $this->isFalse());
    }
}
