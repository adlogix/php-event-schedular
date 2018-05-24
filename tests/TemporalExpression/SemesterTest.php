<?php

declare(strict_types=1);

namespace Adlogix\EventSchedulerTest\TemporalExpression;

use DateTime;
use PHPUnit\Framework\TestCase;
use Adlogix\EventScheduler\TemporalExpression\Semester;

/**
 * @author Toni Van de Voorde <toni@adlogix.eu>
 */
final class SemesterTest extends TestCase
{
    /**
     * @return array
     */
    public function getSuccessfulDataProvider()
    {
        $first = Semester::first();
        $second = Semester::second();

        return [
            [new DateTime('2015-01-01'), $first],
            [new DateTime('2015-04-10'), $first],
            [new DateTime('2015-06-30'), $first],
            [new DateTime('2015-07-01'), $second],
            [new DateTime('2015-10-15'), $second],
            [new DateTime('2015-12-31'), $second],
        ];
    }

    /**
     * @test
     * @dataProvider getSuccessfulDataProvider
     * @param DateTime $date
     * @param          $semester
     */
    public function includes_GivenDateAtSameSemester_ShouldReturnTrue(DateTime $date, $semester)
    {
        $this->includesDate($date, $semester, true);
    }

    /**
     * @return array
     */
    public function getUnsuccessfulDataProvider()
    {
        $first = Semester::first();
        $second = Semester::second();

        return [
            [new DateTime('2015-01-01'), $second],
            [new DateTime('2015-04-10'), $second],
            [new DateTime('2015-06-30'), $second],
            [new DateTime('2015-07-01'), $first],
            [new DateTime('2015-10-15'), $first],
            [new DateTime('2015-12-31'), $first],
        ];
    }

    /**
     * @test
     * @dataProvider getUnsuccessfulDataProvider
     * @param DateTime $date
     * @param Semester $semester
     */
    public function includes_GivenDateAtDifferentSemester_ShouldReturnFalse(DateTime $date, Semester $semester)
    {
        $this->includesDate($date, $semester, false);
    }

    /**
     * @param DateTime $date
     * @param Semester $semester
     * @param bool     $expected
     */
    private function includesDate(DateTime $date, Semester $semester, bool $expected)
    {
        $output = $semester->includes($date);

        $this->assertSame($expected, $output);
    }
}
