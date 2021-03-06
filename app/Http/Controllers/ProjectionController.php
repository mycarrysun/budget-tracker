<?php

namespace App\Http\Controllers;

use App\Expense;
use App\Income;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProjectionController extends Controller
{
    public function index()
    {
        return view('projection.index');
    }

    public function stats(Request $request)
    {
        $view    = $request->input('view', 'd30');
        $balance = (double) $request->input('start_amt');

        session()->put('start_amt', $balance);

        $days = 0;

        switch ($view) {
            case 'd30':
                $days = 30;
                break;

            case 'm3':
                $days = 90;
                break;

            case 'm6':
                $days = 180;
                break;

            case 'm12':
                $days = 365;
                break;
        }

        $items = $this->getNthDaysOfProjectedBalance($request, $days, $balance);

        $data = [
            'labels'   => $items->map(function ($item) {
                return $item->date->toDayDateTimeString();
            }),
            'datasets' => [
                [
                    'label'           => 'Projections',
                    'data'            => $items->pluck('balance'),
                    'backgroundColor' => $items->map(function ($item) {
                        return $item->balance > 0 ? 'green' : 'red';
                    }),
                    'footer'          => $items->map(function ($item) {
                        return $item->income->pluck('label')->implode("\n");
                    }),
                    'afterFooter'     => $items->map(function ($item) {
                        return $item->expenses->pluck('label')->implode("\n");
                    }),
                ],
            ],
        ];

        return $data;
    }

    public function getNthDaysOfProjectedBalance(Request $request, int $days, float $balance)
    {
        $items = collect();

        for ($i = 0; $i < $days; $i++) {
            $item       = new \stdClass();
            $item->date = Carbon::now()->startOfDay()->addDays($i);

            $item->expenses = $request->user()->getExpensesForDate(clone $item->date);
            $item->income   = $request->user()->getIncomeForDate(clone $item->date);

            $balance       = $balance + $item->income->sum('amount') - $item->expenses->sum('amount');
            $item->balance = $balance;

            $items[] = $item;
        }

        return $items;
    }
}
