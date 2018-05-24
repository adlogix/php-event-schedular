<?php

declare(strict_types=1);

namespace Adlogix\EventScheduler;

use Webmozart\Assert\Assert;

/**
 * @author Toni Van de Voorde <toni@adlogix.eu>
 */
final class BasicEvent implements EventInterface
{
    /**
     * @var string
     */
    private $name;

    /**
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * @param BasicEvent $compare
     * @return bool
     */
    public function equals($compare): bool
    {
        Assert::isInstanceOf($compare, BasicEvent::class);
        return $this->name === $compare->__toString();
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->name;
    }
}