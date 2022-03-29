<?php

namespace Core\Domain\ValueObjects;

use Core\Domain\Contracts\ArrayableInterface;
use Core\Domain\Contracts\ComparableInterface;
use Core\Domain\Entities\DomainNotification;

abstract class AbstractBaseValueObject implements ComparableInterface, ArrayableInterface
{
    protected $notifications;

    public function __construct()
    {
        $this->notifications = new DomainNotification();
    }

    public function isValid(): bool
    {
        return $this->notifications->hasNotifications() ? false : true;
    }

    abstract public function equals(ComparableInterface $valueObject): bool;

    public function isValueObject(ComparableInterface $entity): bool
    {
        return $entity instanceof AbstractBaseValueObject;
    }

    public function getNotifications(): array
    {
        return $this->notifications->getNotifications();
    }

    public function __toString()
    {
        return serialize($this);
    }
}
