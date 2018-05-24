<?php

declare(strict_types=1);

namespace Adlogix\EventSchedulerTest;

use DateTime;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject;
use Adlogix\EventScheduler\EventInterface;
use Adlogix\EventScheduler\SchedulableEvent;
use Adlogix\EventScheduler\TemporalExpression\TemporalExpressionInterface;
use Adlogix\EventSchedulerTest\Fixtures\TemporalExpression\AlwaysOccurringTemporalExpression;
use Adlogix\EventSchedulerTest\Fixtures\TemporalExpression\NeverOccurringTemporalExpression;

class SchedulableEventTest extends TestCase
{
    /**
     * @test
     */
    public function isOccurring_WhenEventMatch_ShouldCallIncludesMethod()
    {
        $anyEvent = $this->getEvent();
        $anyEvent
            ->method('equals')
            ->will($this->returnValue(true));

        $anyDate = new DateTime();

        /** @var TemporalExpressionInterface|PHPUnit_Framework_MockObject_MockObject $exprMock */
        $exprMock = $this->createMock(TemporalExpressionInterface::class);
        $exprMock
            ->expects($this->once())
            ->method('includes')
            ->with($anyDate);

        $schedulableEvent = new SchedulableEvent($anyEvent, $exprMock);

        $schedulableEvent->isOccurring($anyEvent, $anyDate);
    }

    /**
     * @test
     */
    public function isOccurring_WhenEventDoesNotMatch_ShouldReturnFalse()
    {
        $exprStub = $this->getTemporalExpression();

        $anyEvent = $this->getEvent();
        $anyEvent
            ->method('equals')
            ->will($this->returnValue(false));

        $anyOtherEvent = $this->getEvent();

        $schedulableEvent = new SchedulableEvent($anyEvent, $exprStub);

        $isOccurring = $schedulableEvent->isOccurring($anyOtherEvent, new DateTime());

        $this->assertThat($isOccurring, $this->isFalse());
    }

    /**
     * @test
     */
    public function isOccurring_WhenEventMatchesAndDateIncludedInTemporalExpression_ShouldReturnTrue()
    {
        $anyEvent = $this->getEvent();
        $anyEvent
            ->method('equals')
            ->will($this->returnValue(true));

        $anyDate = new DateTime();

        $expr = new AlwaysOccurringTemporalExpression();

        $schedulableEvent = new SchedulableEvent($anyEvent, $expr);

        $isOccurring = $schedulableEvent->isOccurring($anyEvent, $anyDate);

        $this->assertThat($isOccurring, $this->isTrue());
    }

    /**
     * @test
     */
    public function isOccurring_WhenEventMatchAndDateNotIncludedInTemporalExpression_ShouldReturnFalse()
    {
        $anyEvent = $this->getEvent();
        $anyEvent
            ->method('equals')
            ->will($this->returnValue(true));

        $anyDate = new DateTime();

        $expr = new NeverOccurringTemporalExpression();

        $schedulableEvent = new SchedulableEvent($anyEvent, $expr);

        $isOccurring = $schedulableEvent->isOccurring($anyEvent, $anyDate);

        $this->assertThat($isOccurring, $this->isFalse());
    }

    /**
     * @return PHPUnit_Framework_MockObject_MockObject|TemporalExpressionInterface
     */
    private function getTemporalExpression():TemporalExpressionInterface
    {
        return $this->createMock(TemporalExpressionInterface::class);
    }

    /**
     * @return PHPUnit_Framework_MockObject_MockObject|EventInterface
     */
    private function getEvent():EventInterface
    {
        return $this->createMock(EventInterface::class);
    }
}
