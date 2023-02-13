<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin IdeHelperLink
 */
class Link extends Model
{
    use HasFactory;

    protected $fillable = ['hash', 'expires_at'];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user:id');
    }

    /**
     * @return HasMany
     */
    public function attempts(): HasMany
    {
        return $this->hasMany(Attempt::class, 'link_id');
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('expires_at', '>', now());
    }

    /**
     * Get the isExpired attribute
     * @return Attribute
     */
    protected function isExpired(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => $attributes['expires_at'] < now(),
        );
    }
}
