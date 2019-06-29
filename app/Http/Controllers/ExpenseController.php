<?php

namespace App\Http\Controllers;

use App\Expense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('items.index', [
            'items'    => $request->user()->expenses()->when($request->has('trash'), function ($query) {
                return $query->onlyTrashed();
            })->get(),
            'singular' => 'expense',
            'plural'   => 'expenses',
            'title'    => 'Expenses',
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
            'singular' => 'expense',
            'plural'   => 'expenses',
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
        $expense = new Expense($request->all());
        $expense->user()->associate($request->user());
        $expense->save();

        return redirect(route('expenses.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Expense  $expense
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Expense $expense)
    {
        return view('items.view', [
            'item'     => $expense,
            'singular' => 'expense',
            'plural'   => 'expenses',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Expense  $expense
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Expense $expense)
    {
        return view('items.form', [
            'item'     => $expense,
            'singular' => 'expense',
            'plural'   => 'expenses',
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Expense  $expense
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Expense $expense)
    {
        $expense->fill($request->all());
        $expense->save();

        return redirect(route('expenses.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Expense  $expense
     *
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Expense $expense)
    {
        $expense->delete();

        return redirect(route('expenses.index'));
    }

    /**
     * @param  Expense  $expense
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function restore($id)
    {
        $expense = Expense::withTrashed()->findOrFail($id);
        $expense->restore();

        return redirect(route('expenses.index'));
    }
}
