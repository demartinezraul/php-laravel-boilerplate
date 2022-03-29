<?php

namespace Core\Infrastructure\Eloquent;

use Illuminate\Database\Eloquent\Model;

class ExampleEloquent extends Model
{

    protected $table = 'Example';
    protected $primaryKey = 'id';

    protected $attributes = [
        'delayed' => false,
    ];

    public $incrementing = true;
    protected $keyType = 'string';
    public $timestamps = true;
    protected $dateFormat = 'U';

    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';

    public function relation()
    {
        return $this->belongsTo(OutroModelEloquent::class, 'foreign_id', 'id');
    }
}
