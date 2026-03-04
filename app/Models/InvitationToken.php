<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvitationToken extends Model
{
    use HasFactory;
    protected $fillable = [
        'email',
        'token',
        'expires_at',
        'colocation_id',
        'used_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'used_at' => 'datetime',
    ];

    public function scopeValid(Builder $query): void
    {
        $query->whereNull('used_at')
            ->where('expires_at', '>', now());
    }

    public function markAsUsed(): bool
    {
        return $this->update(['used_at' => now()]);
    }

    public function colocation(): BelongsTo
    {
        return $this->belongsTo(Colocation::class);
    }
}
