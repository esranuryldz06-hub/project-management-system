<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Project extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'done_jobs',
        'start_date',
        'end_date',
        'status',
        'user_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function teamMembers(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->withTimestamps();
    }
}
