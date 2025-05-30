<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory, SoftDeletes;

    protected $appends = ['status_label'];

    protected $fillable = [
        'owner_id',
        'name',
        'description',
        'address',
        'complement',
        'zipcode',
        'number',
        'city',
        'state',
        'starts_at',
        'ends_at',
        'max_subscription',
        'is_active',
        'uuid_code',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function getRouteKeyName(): string
    {
        return 'uuid_code';
    }

    public function scopeEligible(Builder $query): Builder
    {
        return $query
            ->whereDate('ends_at', '>=', now());
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function guests()
    {
        return $this->hasMany(EventGuest::class, 'event_id');
    }

    public function getStatusLabelAttribute(): string
    {
        if (!$this->is_active) {
            return 'Cancelado';
        }

        if ($this->ends_at->isPast()) {
            return 'Expirado';
        }

        return 'ativo';
    }

    protected static function booted()
    {
        static::creating(function ($event) {
            if (empty($event->uuid_code)) {
                $event->uuid_code = Str::uuid()->toString();
            }
        });
    }
}
