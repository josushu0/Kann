<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

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
                ->orderByDesc('position')
                ->first()?->position + self::POSITION_GAP;
        });

        static::saved(function ($task) {
            if ($task->position < self::MIN_GAP) {
                DB::statement('with pos as (select id, row_number() over (order by id) as new_position from tasks where column_id = ?)
                update tasks set position = (select new_position from pos where id = tasks.id) * ? where id in (select id from pos)',
                    [$task->column_id, self::POSITION_GAP]);
            }
        });
    }

    public function column(): BelongsTo
    {
        return $this->belongsTo(Column::class);
    }
}
