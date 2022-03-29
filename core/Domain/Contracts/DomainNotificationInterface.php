<?php

namespace Core\Domain\Contracts;

use stdClass;

interface DomainNotificationInterface
{
    public function add(string $key, $value): DomainNotificationInterface;
    public function addFromArray(array $arrayOfnotifications): DomainNotificationInterface;
    public function addFromObject(stdClass $objectOfNotifications): DomainNotificationInterface;
    public function addErrorWithCondition(string $error, bool $condition): DomainNotificationInterface;
    public function getNotifications(): array;
    public function hasNotifications(): bool;
    public function count(): int;
}
