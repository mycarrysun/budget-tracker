<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Income extends Model
{
    use SoftDeletes, HasRepeatInterval;

    protected $table = 'income';

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

    public function getLabelAttribute()
    {
        return $this->name.': +'.money_format(MONEY_FORMAT, $this->amount);
    }

    public function setRepeatAttribute($val)
    {
        $this->attributes['repeat'] = $val === 'on';
    }
}
