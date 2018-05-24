<?php

declare(strict_types=1);

namespace Adlogix\EventSchedulerTest\TemporalExpression;

use DateTime;
use DateTimeInterface;
use PHPUnit\Framework\TestCase;
use Adlogix\EventScheduler\TemporalExpression\Trimester;

/**
 * @author Toni Van de Voorde <toni@adlogix.eu>
 */
final class TrimesterTest extends TestCase
{
    public function getSuccessfulDataProvider()
    {
        $first = Trimester::first();
        $second = Trimester::second();
        $third = Trimester::third();
        $fourth = Trimester::fourth();

        return [
            [new DateTime('2015-01-01'), $first],
            [new DateTime('2015-03-31'), $first],
            [new DateTime('2015-04-01'), $second],
            [new DateTime('2015-06-30'), $second],
            [new DateTime('2015-07-01'), $third],
            [new DateTime('2015-09-30'), $third],
            [new DateTime('2015-10-01'), $fourth],
            [new DateTime('2015-12-31'), $fourth],
        ];
    }

    /**
     * @test
     * @dataProvider getSuccessfulDataProvider
     * @param DateTimeInterface $date
     * @param Trimester         $trimester
     */
    public function includes_GivenDateAtSameTrimester_ShouldReturnTrue(
        DateTimeInterface $date,
        Trimester $trimester
    ) {
        $this->includesDate($date, $trimester, true);
    }

    public function getUnsuccessfulDataProvider()
    {
        $first = Trimester::first();
        $second = Trimester::second();
        $third = Trimester::third();
        $fourth = Trimester::fourth();

        return [
            [new DateTime('2015-01-01'), $fourth],
            [new DateTime('2015-03-31'), $fourth],
            [new DateTime('2015-04-01'), $third],
            [new DateTime('2015-06-30'), $third],
            [new DateTime('2015-07-01'), $second],
            [new DateTime('2015-09-30'), $second],
            [new DateTime('2015-10-01'), $first],
            [new DateTime('2015-12-31'), $first],
        ];
    }

    /**
     * @test
     * @dataProvider getUnsuccessfulDataProvider
     * @param DateTimeInterface $date
     * @param Trimester         $trimester
     */
    public function includes_GivenDateAtDifferentTrimester_ShouldReturnFalse(
        DateTimeInterface $date,
        Trimester $trimester
    ) {
        $this->includesDate($date, $trimester, false);
    }

    /**
     * @param DateTimeInterface $date
     * @param Trimester         $trimester
     * @param bool              $expected
     */
    private function includesDate(
        DateTimeInterface $date,
        Trimester $trimester,
        bool $expected
    ) {
        $output = $trimester->includes($date);

        $this->assertSame($expected, $output);
    }
}
