<?php

namespace Core\Infrastructure\Traits;

use Ramsey\Uuid\Uuid;

trait GenerateUUID
{
    public static function bootGenerateUUID()
    {
        static::creating(function ($model) {
            $model->uuid = Uuid::uuid4();
        });
    }
}
