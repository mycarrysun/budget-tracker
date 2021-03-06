<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    public function income()
    {
        return $this->hasMany(Income::class);
    }

    public function getIncomeForDate($date)
    {
        $date = Carbon::parse($date);

        $incomes = $this->income()->where('starts_at', '<=', $date->format('Y-m-d'))->get();

        $incomes = $incomes->filter(function ($income) use ($date) {
            return $income->happensOnDate($date);
        });

        return $incomes;
    }

    public function getExpensesForDate($date)
    {
        $date = Carbon::parse($date);

        $expenses = $this->expenses()->where('starts_at', '<=', $date->format('Y-m-d'))->get();

        $expenses = $expenses->filter(function ($expense) use ($date) {
            return $expense->happensOnDate($date);
        });

        return $expenses;
    }
}
