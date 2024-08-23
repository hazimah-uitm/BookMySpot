<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Attendance extends Model
{
    use LogsActivity;
    use SoftDeletes;

    protected static $logAttributes = ['*'];

    protected static $logOnlyDirty = true;

    protected $fillable = [
        'no_pekerja',
        'name',
        'type',
        'check_in',
    ];

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'no_pekerja', 'no_pekerja');
    }
}
