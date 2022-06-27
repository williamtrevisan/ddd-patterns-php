<?php

declare(strict_types=1);

namespace Domain\shared\Event;

use DateTime;

abstract class Event
{
    public DateTime $dateTimeOccurred;

    public function __construct(
        public mixed $eventData,
    ) {
        $this->dateTimeOccurred = new DateTime();
    }
}
