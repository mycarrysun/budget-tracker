<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expense extends Model
{
    use SoftDeletes, HasRepeatInterval;

    protected $fillable = [
        'name',
        'starts_at',
        'amount',
        'repeat',
        'interval_type',
        'interval_value',
    ];

    protected $casts = [
        'amount' => 'double',
        'repeat' => 'bool',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getStartsAtAttribute($date)
    {
        return Carbon::parse($date)->format('Y-m-d');
    }

    public function setRepeatAttribute($val)
    {
        $this->attributes['repeat'] = $val === 'on';
    }
}
