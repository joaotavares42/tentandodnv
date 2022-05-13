<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bank;


class BankController extends Controller
{
    public function index()
    {
        $banks = Bank::all();
        return response()->json($banks);
    }

    public function store(Request $request)
    {
        $bank = new Bank();

        $bank->fill($request->all());



        $bank->save();

        return ['msg' => 'Banco criado com sucesso'];

    }
}
