<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = ['name', 'description', 'due_date', 'column_id'];

    const float POSITION_GAP = 60000;

    const float MIN_GAP = 1;

    public static function booted()
    {
        static::creating(function ($task) {
            $task->position = self::query()
                ->where('column_id', $task->column_id)
                ->orderBy('position')
                ->first()?->position + self::POSITION_GAP;
        });

        static::saved(function ($task) {
            // TODO
            if ($task->position < self::MIN_GAP) {
            }
        });
    }

    public function column(): BelongsTo
    {
        return $this->belongsTo(Column::class);
    }
}
