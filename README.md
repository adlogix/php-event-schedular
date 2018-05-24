Adlogix Event Scheduler
======================

The Adlogix Event Scheduler library provides a way to manage recurring events using Martin Fowler's [Recurring Event pattern](http://martinfowler.com/apsupp/recurring.pdf). 
The base of the code and documentation was initially forked from [RiskioFr's solution](https://github.com/RiskioFr/EventScheduler)  and completely refactored to be more lightweight and with less dependencies!

[![Build Status](https://travis-ci.org/adlogix/php-event-schedular.svg)](https://travis-ci.org/adlogix/php-event-schedular)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/adlogix/php-event-schedular/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/adlogix/php-event-schedular/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/adlogix/php-event-schedular/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/adlogix/php-event-schedular/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/adlogix/php-event-scheduler/v/stable)](https://packagist.org/packages/adlogix/php-event-scheduler)
[![Total Downloads](https://poser.pugx.org/adlogix/php-event-scheduler/downloads)](https://packagist.org/packages/adlogix/php-event-scheduler)
[![Latest Unstable Version](https://poser.pugx.org/adlogix/php-event-scheduler/v/unstable)](https://packagist.org/packages/adlogix/php-event-scheduler)
[![License](https://poser.pugx.org/adlogix/php-event-scheduler/license)](https://packagist.org/packages/adlogix/php-event-scheduler)


Requirements
------------

* PHP 7.1 or higher

Documentation
-------------

The documentation will help you to understand how to use and extend Schedule.

### Introduction

The schedule represented by ```Adlogix\EventScheduler\Scheduler``` class allows you to know if any event occurs at a given date.

### Usage

To start, you must instantiate ```Adlogix\EventScheduler\Scheduler``` and schedule some events
using `Adlogix\EventScheduler\Scheduler::schedule` method.

This example schedule an event with `DayInMonth` temporal expression. So, the event will occur at 15th day of each coming months.

```php
use Adlogix\EventScheduler\Scheduler;
use Adlogix\EventScheduler\TemporalExpression;

$scheduler = new Scheduler();
$scheduledEvent = $scheduler->schedule(new BasicEvent('event_name'), new TemporalExpression\DayInMonth(15));
```

If you want to cancel this event, you can provide the returned instance of `Adlogix\EventScheduler\SchedulableEvent` to the `Adlogix\EventScheduler\Scheduler::cancel` method.

```php
$scheduler->cancel($scheduledEvent);
```

### Temporal Expressions

A temporal expression implements `Adlogix\EventScheduler\TemporalExpression\TemporalExpressionInterface` that provides useful `isOccurring` method to
check if an event occur or not at a given date represented by an instance of `DateTimeInterface`.

```php
$temporalExpression = new TemporalExpression();

$isOccuring = $temporalExpression->isOccuring(new BasicEvent('event_name'), $date);
```

#### Default temporal expressions

By default, there are some temporal expressions that you can use to define event recurrence.

##### EachDay

- class: Adlogix\EventScheduler\TemporalExpression\EachDay

###### Example

```php
use Adlogix\EventScheduler\TemporalExpression\EachDay;

$expression = new EachDay();
```

##### DayInWeek

- class: Adlogix\EventScheduler\TemporalExpression\DayInWeek
- parameters: day (1-7)

###### Examples

```php
use Adlogix\EventScheduler\TemporalExpression\DayInWeek;
use Adlogix\EventScheduler\ValueObject\WeekDay;

$expression = new DayInWeek(WeekDay::MONDAY);

$expression = DayInWeek::monday();
```

##### DayInMonth

- class: Adlogix\EventScheduler\TemporalExpression\DayInMonth
- parameters: day (1-31)

###### Example

```php
use Adlogix\EventScheduler\TemporalExpression\DayInMonth;

$expression = new DayInMonth(15);
```

##### WeekInYear

- class: Adlogix\EventScheduler\TemporalExpression\WeekInYear
- parameters: month (1-12)

###### Example

```php
use Adlogix\EventScheduler\TemporalExpression\WeekInYear;
use Adlogix\EventScheduler\ValueObject\Month;

$expression = new WeekInYear(15);
```

##### MonthInYear

- class: Adlogix\EventScheduler\TemporalExpression\MonthInYear
- parameters: month (1-12)

###### Examples

```php
use Adlogix\EventScheduler\TemporalExpression\MonthInYear;
use Adlogix\EventScheduler\ValueObject\Month;

$expression = new MonthInYear(Month::JANUARY);

$expression = MonthInYear::january();
```

##### Semester

- class: Adlogix\EventScheduler\TemporalExpression\Semester
- parameters: semester (1-2)

###### Example

```php
use Adlogix\EventScheduler\TemporalExpression\Semester;

$expression = new Semester(1);
```

##### Trimester

- class: Adlogix\EventScheduler\TemporalExpression\Trimester
- parameters: trimester (1-4)

###### Example

```php
use Adlogix\EventScheduler\TemporalExpression\Trimester;

$expression = new Trimester(1);
```

##### Year

- class: Adlogix\EventScheduler\TemporalExpression\Year
- parameters: year

###### Example

```php
use Adlogix\EventScheduler\TemporalExpression\Year;

$expression = new Year(2015);
```

##### LeapYear

- class: Adlogix\EventScheduler\TemporalExpression\LeapYear

###### Example

```php
use Adlogix\EventScheduler\TemporalExpression\LeapYear;

$expression = new LeapYear();
```

##### From

- class: Adlogix\EventScheduler\TemporalExpression\From
- parameters: `DateTimeInterface` instance

###### Example

```php
use DateTime;
use Adlogix\EventScheduler\TemporalExpression\From;

$date = new DateTime();
$expression = new From($date);
```

##### Until

- class: Adlogix\EventScheduler\TemporalExpression\Until
- parameters: `DateTimeInterface` instance

###### Example

```php
use DateTime;
use Adlogix\EventScheduler\TemporalExpression\Until;

$date = new DateTime();
$expression = new Until($date);
```

##### RangeEachYear

- class: Adlogix\EventScheduler\TemporalExpression\RangeEachYear
- parameters:
  - start month (1-12)
  - end month (1-12)
  - start day (1-31)
  - end day (1-31)

###### Examples

```php
use Adlogix\EventScheduler\TemporalExpression\RangeEachYear;

// From January to March inclusive
$expression = new RangeEachYear(1, 3);

// From January 10 to March 20
$expression = new RangeEachYear(1, 3, 10, 20);
```

#### Composite Temporal Expressions

In order to create complex temporal expressions, you can use composite temporal expressions
that allow to build combinaisons of previous ones.

##### Intersection

An event is occuring at a given date if it lies within all temporal expressions.

###### Example

```php
use DateTime;
use Adlogix\EventScheduler\TemporalExpression\Collection\Intersection;
use Adlogix\EventScheduler\TemporalExpression\DayInMonth;
use Adlogix\EventScheduler\TemporalExpression\MonthInYear;

$intersection = new Intersection();
$intersection->addElement(new DayInMonth(15));
$intersection->addElement(MonthInYear::january());

$intersection->isOccuring('event', new DateTime('2015-01-15')); // returns true
$intersection->isOccuring('event', new DateTime('2015-01-16')); // returns false
$intersection->isOccuring('event', new DateTime('2015-02-15')); // returns false
```

##### Union

An event is occuring at a given date if it lies within at least one temporal expression.

###### Example

```php
use DateTime;
use Adlogix\EventScheduler\TemporalExpression\Collection\Union;
use Adlogix\EventScheduler\TemporalExpression\DayInMonth;
use Adlogix\EventScheduler\TemporalExpression\MonthInYear;

$union = new Union();
$intersection->addElement(new DayInMonth(15));
$intersection->addElement(MonthInYear::january());

$intersection->isOccuring('event', new DateTime('2015-01-15')); // returns true
$intersection->isOccuring('event', new DateTime('2015-01-16')); // returns false
$intersection->isOccuring('event', new DateTime('2015-02-15')); // returns true
```

##### Difference

An event is occuring at a given date if it lies within first temporal expression and not within the second one.

###### Example

```php
use DateTime;
use Adlogix\EventScheduler\TemporalExpression\DayInMonth;
use Adlogix\EventScheduler\TemporalExpression\Difference;
use Adlogix\EventScheduler\TemporalExpression\MonthInYear;

$difference = new Difference(MonthInYear::january(), new DayInMonth(15));

$intersection->isOccuring('event', new DateTime('2015-01-15')); // returns false
$intersection->isOccuring('event', new DateTime('2015-01-16')); // returns true
$intersection->isOccuring('event', new DateTime('2015-02-15')); // returns false
```

#### Custom Temporal Expressions

You can create temporal expressions that match your special needs by implementing `Adlogix\EventScheduler\TemporalExpression\TemporalExpressionInterface`.

### Cookbook

After detailing the different temporal expressions available, consider a concrete case with complex temporal expression that could be used in real life.

In the example below, we include every Saturday and Sunday except on July and August.

```php
use Adlogix\EventScheduler\TemporalExpression\Collection\Union;
use Adlogix\EventScheduler\TemporalExpression\DayInWeek;
use Adlogix\EventScheduler\TemporalExpression\Difference;
use Adlogix\EventScheduler\TemporalExpression\MonthInYear;

$includedWeekDays = new Union();
$union->addElement(DayInWeek::saturday());
$union->addElement(DayInWeek::sunday());

$excludedMonths = new Union();
$union->addElement(MonthInYear::july());
$union->addElement(MonthInYear::august());

$expression = new Difference($includedWeekDays, $excludedMonths);
```
