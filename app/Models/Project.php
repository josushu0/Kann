<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Project extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = ['name', 'description', 'start_date', 'end_date'];

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }
}
