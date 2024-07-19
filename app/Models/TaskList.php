<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TaskList extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'position',
    ];

    const float POSITION_GAP = 60000;

    const float MIN_GAP = 1;

    public static function booted()
    {
        /*
         * When creating a new list make position = last list position + gap
         */
        static::creating(function ($column) {
            $column->position = self::query()
                ->where('project_id', $column->project_id)
                ->orderByDesc('position')
                ->first()?->position + self::POSITION_GAP;
        });

        /*
         * Reorder lists when position is very small
         */
        static::saved(function ($column) {
            if ($column->position < self::MIN_GAP) {
                DB::statement('with pos as (select id, row_number() over (order by id) as new_position from columns where project_id = ?)
                update columns set position = (select new_position from pos where id = columns.id) * ? where id in (select id from pos)',
                    [$column->project_id, self::POSITION_GAP]);
            }
        });
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
