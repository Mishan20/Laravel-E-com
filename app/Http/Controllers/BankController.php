<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\BankRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class BankController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $banks = Bank::paginate();

        return view('bank.index', compact('banks'))
            ->with('i', ($request->input('page', 1) - 1) * $banks->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $bank = new Bank();

        return view('bank.create', compact('bank'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BankRequest $request): RedirectResponse
    {
        Bank::create($request->validated());

        return Redirect::route('banks.index')
            ->with('success', 'Bank created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $bank = Bank::find($id);

        return view('bank.show', compact('bank'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $bank = Bank::find($id);

        return view('bank.edit', compact('bank'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BankRequest $request, Bank $bank): RedirectResponse
    {
        $bank->update($request->validated());

        return Redirect::route('banks.index')
            ->with('success', 'Bank updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        Bank::find($id)->delete();

        return Redirect::route('banks.index')
            ->with('success', 'Bank deleted successfully');
    }
}
