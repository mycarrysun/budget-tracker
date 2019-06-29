<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Support\Str;

trait HasRepeatInterval
{
    private $interval_codes = ['d', 'w', 'm'];

    public function intervalOptions()
    {
        return [
            [
                'label' => 'Every (x) of the month',
                'value' => 'm',
            ],
            [
                'label' => 'Every (x) weeks',
                'value' => 'w',
            ],
            [
                'label' => 'Every (x) days',
                'value' => 'd',
            ],
        ];
    }

    public function getRepeatTextAttribute()
    {
        if (! $this->repeat || ! in_array($this->interval_type, $this->interval_codes)) {
            return 'none';
        }

        switch ($this->interval_type) {
            case 'd':
                $text = 'every ';
                $text .= $this->interval_value;
                $text .= ' '.Str::plural('day', $this->interval_value);

                return $text;
                break;

            case 'w':
                return 'every '
                    .$this->interval_value
                    .' '
                    .Str::plural('week', $this->interval_value)
                    .' on '
                    .Carbon::parse($this->starts_at)->englishDayOfWeek;
                break;

            case 'm':
                $text = (new \NumberFormatter('en_US', \NumberFormatter::ORDINAL))->format($this->interval_value);

                return 'every '.$text.' of the month';
        }
    }

    public function happensOnDate($date)
    {
        $date = Carbon::parse($date);

        if (! $this->repeat) {
            return Carbon::parse($this->starts_at)->eq($date);
        }

        switch ($this->interval_type) {
            case 'd':
                return ($date->diffInDays(Carbon::parse($this->starts_at)) % $this->interval_value) === 0;
                break;

            case 'w':
                return $date->dayOfWeek === Carbon::parse($this->starts_at)->dayOfWeek;
                break;

            case 'm':
                return $date->day === $this->interval_value;
                break;
        }

        return false;
    }
}