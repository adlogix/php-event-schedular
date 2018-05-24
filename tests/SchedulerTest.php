<?php

declare(strict_types=1);

namespace Adlogix\EventSchedulerTest;

use DateTime;
use DateTimeImmutable;
use DateTimeInterface;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject;
use Adlogix\EventScheduler\BasicEvent;
use Adlogix\EventScheduler\DateRange\DateRange;
use Adlogix\EventScheduler\Exception\NotFoundEventOccurrenceException;
use Adlogix\EventScheduler\Exception\NotScheduledEventException;
use Adlogix\EventScheduler\SchedulableEvent;
use Adlogix\EventScheduler\Scheduler;
use Adlogix\EventScheduler\TemporalExpression\TemporalExpressionInterface;
use Adlogix\EventSchedulerTest\Fixtures\TemporalExpression\AlwaysOccurringTemporalExpression;
use Adlogix\EventSchedulerTest\Fixtures\TemporalExpression\NeverOccurringTemporalExpression;
use Traversable;

class SchedulerTest extends TestCase
{
    /**
     * @test
     */
    public function cancel_WhenEventIsNotScheduled_ShouldThrowException()
    {
        $anyEvent = new BasicEvent('some_event');
        $anyTemporalExpression = $this->getTemporalExpression();
        $anySchedulableEvent = new SchedulableEvent($anyEvent, $anyTemporalExpression);
        $scheduler = new Scheduler();

        $this->expectException(NotScheduledEventException::class);
        $scheduler->cancel($anySchedulableEvent);
    }

    /**
     * @test
     */
    public function cancel_WhenEventIsScheduled_ShouldNoLongerScheduled()
    {
        $anyEvent = new BasicEvent('some_event');
        $anyTemporalExpression = $this->getTemporalExpression();
        $scheduler = new Scheduler();
        $schedulableEvent = $scheduler->schedule($anyEvent, $anyTemporalExpression);

        $scheduler->cancel($schedulableEvent);

        $this->assertThat($scheduler->isScheduled($anyEvent), $this->isFalse());
    }

    /**
     * @test
     */
    public function isOccurring_WhenEventIsNotScheduled_ShouldReturnFalse()
    {
        $anyEvent = new BasicEvent('some_event');
        $scheduler = new Scheduler();

        $isOccurring = $scheduler->isOccurring($anyEvent, new DateTime());

        $this->assertThat($isOccurring, $this->isFalse());
    }

    /**
     * @test
     */
    public function isOccurring_WhenEventIsOccurring_ShouldReturnTrue()
    {
        $anyEvent = new BasicEvent('some_event');
        $anyTemporalExpression = new AlwaysOccurringTemporalExpression();
        $scheduler = new Scheduler();
        $scheduler->schedule($anyEvent, $anyTemporalExpression);

        $isOccurring = $scheduler->isOccurring($anyEvent, new DateTime());

        $this->assertThat($isOccurring, $this->isTrue());
    }

    /**
     * @test
     */
    public function isOccurring_WhenEventIsNotOccurring_ShouldReturnFalse()
    {
        $anyEvent = new BasicEvent('some_event');
        $anyTemporalExpression = new NeverOccurringTemporalExpression();
        $scheduler = new Scheduler();
        $scheduler->schedule($anyEvent, $anyTemporalExpression);

        $isOccurring = $scheduler->isOccurring($anyEvent, new DateTime());

        $this->assertThat($isOccurring, $this->isFalse());
    }

    /**
     * @test
     */
    public function eventsForDate_WhenSomeEventsScheduledAtSameDate_ShouldReturnATraversableWithScheduledEvents()
    {
        $anyDate = new DateTime();

        $scheduler = new Scheduler();
        $exprStub = $this->getTemporalExpression();
        $exprStub
            ->method('includes')
            ->will($this->returnValue(true));

        $events = [];
        for ($i = 0; $i < 3; $i++) {
            $anyEvent = new BasicEvent('some_event');
            $anyTemporalExpression = $this->getTemporalExpression();

            $scheduler->schedule($anyEvent, $anyTemporalExpression);

            $events[] = $anyEvent;
        }

        $scheduledEvents = $scheduler->eventsForDate($anyDate);
        $this->assertInstanceOf(Traversable::class, $scheduledEvents);

        foreach ($scheduledEvents as $key => $scheduledEvent) {
            $this->assertSame($events[$key], $scheduledEvent);
        }
    }

    /**
     * @test
     */
    public function retrieveDates_WhenEventIsOccurringInProvidedRange_ShouldReturnATraversableWithOccurringDates()
    {
        $anyEvent = new BasicEvent('some_event');

        $startDate = new DateTimeImmutable('2015-03-01');
        $endDate = new DateTimeImmutable('2015-03-30');
        $range = new DateRange($startDate, $endDate);

        $occurringDates = [
            new DateTimeImmutable('2015-03-12'),
            new DateTimeImmutable('2015-03-15'),
        ];

        $scheduler = new Scheduler();

        $exprStub = $this->getTemporalExpressionIncludingDates($occurringDates);

        $scheduler->schedule($anyEvent, $exprStub);

        $dates = $scheduler->dates($anyEvent, $range);
        $this->assertInstanceOf(Traversable::class, $dates);

        foreach ($dates as $key => $date) {
            $this->assertInstanceOf(DateTimeImmutable::class, $date);
            $this->assertEquals($occurringDates[$key], $date);
        }
    }

    /**
     * @test
     */
    public function retrieveNextEventOccurrence_WhenEventWillOccurAgain_ShouldReturnNextDate()
    {
        $anyEvent = new BasicEvent('some_event');

        $occurringDates = [
            new DateTime('2015-10-11'),
            new DateTime('2015-10-15'),
        ];
        $expectedDate = new DateTimeImmutable('2015-10-11');

        $dateRange = new DateRange(
            new DateTimeImmutable('2015-09-01'),
            new DateTimeImmutable('2015-11-01')
        );
        $scheduler = new Scheduler();

        $exprStub = $this->getTemporalExpressionIncludingDates($occurringDates);

        $scheduler->schedule($anyEvent, $exprStub);

        $date = $scheduler->nextOccurrence($anyEvent, $dateRange);

        $this->assertInstanceOf(DateTimeImmutable::class, $date);
        $this->assertEquals($expectedDate, $date);
    }

    /**
     * @test
     */
    public function retrieveNextEventOccurrence_WhenEventWillOccurAgain_ShouldThrowException()
    {
        $anyEvent = new BasicEvent('some_event');

        $occurringDates = [];

        $dateRange = new DateRange(
            new DateTimeImmutable('2014-03-01'),
            new DateTimeImmutable('2014-04-01')
        );
        $scheduler = new Scheduler();

        $exprStub = $this->getTemporalExpressionIncludingDates($occurringDates);

        $scheduler->schedule($anyEvent, $exprStub);

        $this->expectException(NotFoundEventOccurrenceException::class);
        $scheduler->nextOccurrence($anyEvent, $dateRange);
    }

    /**
     * @test
     */
    public function retrieveNextEventOccurrence_WhenThereAreNoNextOccurence_ShouldThrowException()
    {
        $anyEvent = new BasicEvent('some_event');
        $dateRange = new DateRange(
            new DateTimeImmutable('2014-03-01'),
            new DateTimeImmutable('2014-06-01')
        );

        $scheduler = new Scheduler();

        $this->expectException(NotFoundEventOccurrenceException::class);
        $scheduler->nextOccurrence($anyEvent, $dateRange);
    }

    /**
     * @test
     */
    public function retrievePreviousEventOccurrence_WhenEventHasAlreadyOccurred_ShouldReturnPreviousDate()
    {
        $anyEvent = new BasicEvent('some_event');

        $occurringDates = [
            new DateTime('2014-10-12'),
            new DateTime('2014-10-15'),
        ];
        $expectedDate = new DateTimeImmutable('2014-10-15');

        $dateRange = new DateRange(
            new DateTimeImmutable('2014-09-01'),
            new DateTimeImmutable('2014-11-01')
        );
        $scheduler = new Scheduler();

        $exprStub = $this->getTemporalExpressionIncludingDates($occurringDates);

        $scheduler->schedule($anyEvent, $exprStub);

        $date = $scheduler->previousOccurrence($anyEvent, $dateRange);

        $this->assertInstanceOf(DateTimeImmutable::class, $date);
        $this->assertEquals($expectedDate, $date);
    }

    /**
     * @test
     */
    public function retrievePreviousEventOccurrence_WhenThereAreNoPreviousOccurence_ShouldThrowException()
    {
        $anyEvent = new BasicEvent('some_event');

        $dateRange = new DateRange(
            new DateTimeImmutable('2014-03-01'),
            new DateTimeImmutable('2014-04-01')
        );
        $scheduler = new Scheduler();

        $this->expectException(NotFoundEventOccurrenceException::class);
        $scheduler->previousOccurrence($anyEvent, $dateRange);
    }

    /**
     * @return PHPUnit_Framework_MockObject_MockObject|TemporalExpressionInterface
     */
    private function getTemporalExpression(): TemporalExpressionInterface
    {
        return $this->createMock(TemporalExpressionInterface::class);
    }

    /**
     * @param $includedDates
     * @return PHPUnit_Framework_MockObject_MockObject|TemporalExpressionInterface
     */
    private function getTemporalExpressionIncludingDates($includedDates): TemporalExpressionInterface
    {
        $exprStub = $this->getTemporalExpression();
        $exprStub
            ->method('includes')
            ->will($this->returnCallback(function (DateTimeInterface $date) use ($includedDates) {
                return in_array($date, $includedDates);
            }));

        return $exprStub;
    }
}
