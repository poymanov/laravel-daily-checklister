<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin IdeHelperTask
 */
class Task extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = [
        'completed_at',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function checklist()
    {
        return $this->belongsTo(Checklist::class);
    }

    /**
     * @return bool
     */
    public function getCompletedAttribute(): bool
    {
        return $this->completed_by && $this->completed_at;
    }
}
