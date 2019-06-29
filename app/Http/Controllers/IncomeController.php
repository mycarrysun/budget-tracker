<?php

namespace App\Http\Controllers;

use App\Income;
use Illuminate\Http\Request;

class IncomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('items.index', [
            'items'    => $request->user()->income()->when($request->has('trash'), function ($query) {
                return $query->onlyTrashed();
            })->get(),
            'singular' => 'income',
            'plural'   => 'income',
            'title'    => 'Income',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('items.form', [
            'singular' => 'income',
            'plural'   => 'income',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $income = new Income($request->all());
        $income->user()->associate($request->user());
        $income->save();

        return redirect(route('income.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Income  $income
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Income $income)
    {
        return view('items.view', [
            'item'     => $income,
            'singular' => 'income',
            'plural'   => 'income',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Income  $income
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Income $income)
    {
        return view('items.form', [
            'item'     => $income,
            'singular' => 'income',
            'plural'   => 'income',
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Income  $income
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Income $income)
    {
        $income->fill($request->all());
        $income->save();

        return redirect(route('income.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Income  $income
     *
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Income $income)
    {
        $income->delete();

        return redirect(route('income.index'));
    }

    /**
     * @param  Income  $income
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function restore($id)
    {
        $income = Income::withTrashed()->findOrFail($id);
        $income->restore();

        return redirect(route('income.index'));
    }
}
