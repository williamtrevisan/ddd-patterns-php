<?php

declare(strict_types=1);

namespace Domain\Event;

use DateTime;

abstract class Event
{
    public mixed $eventData;
    public DateTime $dateTimeOccurred;
}
