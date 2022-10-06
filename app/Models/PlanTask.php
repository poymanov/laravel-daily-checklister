<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperPlanTask
 */
class PlanTask extends Model
{
    use HasFactory;

    protected $dates = [
        'date',
    ];
}
