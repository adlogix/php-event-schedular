<?php

declare(strict_types=1);

namespace Adlogix\EventSchedulerTest\TemporalExpression;

use DateTime;
use PHPUnit\Framework\TestCase;
use Adlogix\EventScheduler\TemporalExpression\From;

class FromTest extends TestCase
{
    /**
     * @test
     */
    public function includes_GivenMoreRecentDate_ShouldReturnTrue()
    {
        $date = new DateTime('2015-04-12');
        $expr = new From($date);

        $isIncluded = $expr->includes(new DateTime('2015-04-13'));

        $this->assertThat($isIncluded, $this->isTrue());
    }

    /**
     * @test
     */
    public function includes_GivenOlderDate_ShouldReturnFalse()
    {
        $date = new DateTime('2015-04-12');
        $expr = new From($date);

        $isIncluded = $expr->includes(new DateTime('2015-04-11'));

        $this->assertThat($isIncluded, $this->isFalse());
    }
}
