<?php
/*
 * This file is part of the Adlogix package.
 *
 * (c) Allan Segebarth <allan@adlogix.eu>
 * (c) Jean-Jacques Courtens <jjc@adlogix.eu>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Adlogix\EventScheduler\BasicEvent;
use Adlogix\EventScheduler\TemporalExpression\Collection\Intersection;
use Adlogix\EventScheduler\TemporalExpression\Collection\Union;
use Adlogix\EventScheduler\TemporalExpression\DayInWeek;
use Adlogix\EventScheduler\TemporalExpression\Difference;
use Adlogix\EventScheduler\TemporalExpression\From;
use Adlogix\EventScheduler\TemporalExpression\TemporalExpressionInterface;
use Adlogix\EventScheduler\TemporalExpression\Until;
use Adlogix\EventScheduler\TemporalExpression\WeekInYear;

require "vendor/autoload.php";

final class FixedDay implements TemporalExpressionInterface
{
    /**
     * @var DateTimeInterface
     */
    private $date;

    /**
     * @param DateTimeInterface $date
     */
    public function __construct(DateTimeInterface $date)
    {
        $this->date = $date;
    }

    public function includes(DateTimeInterface $date): bool
    {
        $intersection = (new Intersection())
            ->addElement(new From($this->date))
            ->addElement(new Until($this->date));

        return $intersection->includes($date);
    }
}

$scheduler = new \Adlogix\EventScheduler\Scheduler();

$titleFixedDayExpression = new Union();
$titleFixedDayExpression
    ->addElement(new FixedDay(new DateTime('2018-06-01')))
    ->addElement(new FixedDay(new DateTime('2018-08-02')))
    ->addElement(new FixedDay(new DateTime('2018-09-22')));

$titleExpression = new Intersection();
$titleExpression
    ->addElement(new From(new DateTime('2018-02-01')))
    ->addElement(
        (new Union())
            ->addElement(DayInWeek::saturday())
            ->addElement(DayInWeek::wednesday())
            ->addElement($titleFixedDayExpression)
    );

$holidayExpression = new WeekInYear(38);


$expression = new Difference($titleExpression, $holidayExpression);


$myEvent = new BasicEvent('test');
$scheduler->schedule($myEvent, $expression);


//echo $scheduler->nextOccurrence($myEvent, new DateTime(), (new DateTime())->modify('+8 month'))->format('Y-m-d') . "\n";

echo var_export($scheduler->isOccurring($myEvent, new DateTime('2018-06-01'))) . "\n";
echo var_export($scheduler->isOccurring($myEvent, new DateTime('2018-05-16'))) . "\n";


$dates = $scheduler->dates($myEvent,
    new \Adlogix\EventScheduler\DateRange\DateRange(new DateTime('2018-01-01'), new DateTime('2018-12-31')));
foreach ($dates as $date) {
    echo "- " . $date->format('Y-m-d') . "\n";
}
