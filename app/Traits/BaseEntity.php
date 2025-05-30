<?php

// app/Traits/BaseEntity.php
namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait BaseEntity
{
    public static function bootBaseEntity()
    {
        static::creating(function ($model) {
            if (empty($model->uuid_code)) {
                $model->uuid_code = Str::uuid();
            }
        });
    }

    public $incrementing = true;
    protected $keyType = 'int';

    protected $dates = [
        'created_at', 'updated_at', 'deleted_at',
    ];

    use \Illuminate\Database\Eloquent\SoftDeletes;
}
