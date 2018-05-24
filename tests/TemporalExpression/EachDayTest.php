<?php

declare(strict_types=1);

namespace Adlogix\EventSchedulerTest\TemporalExpression;

use PHPUnit\Framework\TestCase;
use Adlogix\EventScheduler\TemporalExpression\EachDay;

class EachDayTest extends TestCase
{
    /**
     * @test
     */
    public function includes_GivenAnyDate_ShouldReturnTrue()
    {
        /** @var \DateTimeInterface $date */
        $date = $this->createMock(\DateTime::class);
        $expr = new EachDay();

        $isIncluded = $expr->includes($date);

        $this->assertThat($isIncluded, $this->isTrue());
    }
}
