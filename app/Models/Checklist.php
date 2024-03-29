<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin IdeHelperChecklist
 */
class Checklist extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $casts = [
        'is_top' => 'boolean',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function group()
    {
        return $this->belongsTo(ChecklistGroup::class, 'checklist_group_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function completedTasks()
    {
        return $this->hasMany(Task::class, 'checklist_id', 'id')->whereNotNull(['completed_by', 'completed_at']);
    }
}
