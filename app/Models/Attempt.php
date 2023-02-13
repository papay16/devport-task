<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin IdeHelperAttempt
 */
class Attempt extends Model
{
    use HasFactory;

    public const RESULT_LOSE = 0;
    public const RESULT_WIN = 1;

    protected $fillable = ['link_id', 'value', 'result', 'prize'];

    /**
     * @return BelongsTo
     */
    public function link(): BelongsTo
    {
        return $this->belongsTo(Link::class, 'link_id');
    }

    /**
     * Get the result attribute
     *
     * If value attribute even - result Win. Otherwise Lose.
     *
     * @return Attribute
     */
    protected function result(): Attribute
    {
        return Attribute::make(
            get: static fn ($value, $attributes) => $attributes['result'] === self::RESULT_WIN ? 'Win' : 'Lose',
        );
    }
}
