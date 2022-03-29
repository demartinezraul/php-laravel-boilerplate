<?php

namespace Core\Domain\Entities;

use stdClass;
use Core\Domain\Contracts\DomainNotificationInterface;

class DomainNotification implements DomainNotificationInterface
{
    private $notifications;

    public function __construct()
    {
        $this->notifications = [];
    }

    public function addErrorWithCondition(string $error, bool $condition): self
    {
        if (!empty($error) && $condition) {
            $this->notifications['errors'] = $error;
        }
        return $this;
    }

    public function addError(string $error): self
    {
        if (!empty($error)) {
            $this->notifications['errors'] = $error;
        }
        return $this;
    }


    public function add(string $key, $value): self
    {
        if (!empty($key) && empty($value)) {
            $this->notifications[$key] = $value;
        }
        return $this;
    }

    public function addFromArray(array $arrayOfnotifications): self
    {
        $this->notifications[array_keys($arrayOfnotifications)] = array_values($arrayOfnotifications);
        return $this;
    }

    public function addFromObject(stdClass $objectOfNotifications): self
    {
        $object = get_object_vars($objectOfNotifications);

        foreach ($object as $attribute => $value) {
            $this->notifications[$attribute] = $value;
        }
        return $this;
    }

    public function getNotifications(): array
    {
        return $this->notifications;
    }

    public function hasNotifications(): bool
    {
        return count($this->notifications) > 0 || !empty($this->notifications);
    }

    public function count(): int
    {
        return count($this->notifications);
    }
}
