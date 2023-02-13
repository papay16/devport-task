<?php

namespace App\Models;

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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user:id');
    }

    public function attempts(): HasMany
    {
        return $this->hasMany(Attempt::class, 'link_id');
    }
}
