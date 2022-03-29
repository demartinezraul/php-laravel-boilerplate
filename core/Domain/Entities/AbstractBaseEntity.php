<?php

namespace Core\Domain\Entities;

use DateTime;
use Core\Domain\Contracts\ComparableInterface;
use DateTimeZone;
use Ramsey\Uuid\Uuid;

abstract class AbstractBaseEntity implements ComparableInterface
{
    protected int $id;
    protected string $uuid;
    protected $notifications;

    public function __construct()
    {
        $this->notifications = new DomainNotification();
    }

    public function isValid(): bool
    {
        return $this->notifications->hasNotifications() ? false : true;
    }

    public function equals(ComparableInterface $entity): bool
    {
        if (is_null($entity)) {
            return false;
        }

        if ($this === $entity || $this->__toString() == $entity->__toString()) {
            return true;
        }

        if (!$this->isEntity($entity)) {
            return false;
        }

        return $this->id === $entity->getID();
    }

    public function isActive(): bool
    {
        return !is_null($this->deletedAt) || $this->active;
    }

    private function isEntity(ComparableInterface $entity): bool
    {
        return $entity instanceof AbstractBaseEntity;
    }

    public function getNotifications(): string
    {
        return implode(',', $this->notifications->getNotifications());
    }

    public function getUUID(): string
    {
        return $this->uuid;
    }

    public function setUUID(string $uuid): self
    {
        $this->uuid = $uuid;
        return $this;
    }

    public function getID(): int
    {
        return $this->id ?: 0;
    }

    public function setID(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): string
    {
        return $this->updatedAt;
    }

    public function getDeletedAt(): string
    {
        return $this->deletedAt;
    }

    public function __toString()
    {
        return serialize($this);
    }
}
