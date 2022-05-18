<?php

namespace App\Http\Controllers;
use App\Models\Payment;
use App\Models\Transfer;
use App\Models\Withdraw;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExtractController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $account = Auth::user()->account()->first();
        $payments = Payment::where('account_id', $account->id)->get();
        $transfers_out = Transfer::where('from_account_id', $account->id)->get();
        $transfers_in = Transfer::where('to_account_id', $account->id)->get();
        $withdrawals = Withdraw::where('account_id', $account->id)->get();

        return response()->json(['msg' => 'Suas movimentacoes',
            'data' => [
                'Pagamentos' => $payments,
                'Transferencias feitas' => $transfers_out,
                'Transferencias recebidas' => $transfers_in,
                'Saques' => $withdrawals
            ]]);
    }
}
