<?php

namespace Core\Domain\Contracts;

interface ComparableInterface
{
    public function equals(ComparableInterface $object);
}
