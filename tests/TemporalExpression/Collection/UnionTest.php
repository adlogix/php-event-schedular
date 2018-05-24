<?php

declare(strict_types=1);

namespace Adlogix\EventSchedulerTest\TemporalExpression\Collection;

use DateTime;
use PHPUnit\Framework\TestCase;
use Adlogix\EventScheduler\TemporalExpression\Collection\Union;
use Adlogix\EventScheduler\TemporalExpression\TemporalExpressionInterface;

class UnionTest extends TestCase
{
    public function getDataProvider()
    {
        return [
            [true, true, true],
            [true, false, true],
            [false, true, true],
            [false, false, false],
        ];
    }

    /**
     * @test
     * @dataProvider getDataProvider
     */
    public function includes_GivenDatesFromDataProvider_ShouldMatchExpectedValue($first, $second, $expected)
    {
        $anyDate = new DateTime();

        $expr = new Union();

        $firstExpr = $this->prophesize(TemporalExpressionInterface::class);
        $firstExpr->includes($anyDate)->willReturn($first);
        $expr->addElement($firstExpr->reveal());

        $secondExpr = $this->prophesize(TemporalExpressionInterface::class);
        $secondExpr->includes($anyDate)->willReturn($second);
        $expr->addElement($secondExpr->reveal());

        $isIncluded = $expr->includes($anyDate);

        $this->assertSame($expected, $isIncluded);
    }
}
