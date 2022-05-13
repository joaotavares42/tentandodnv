<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Withdraw;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class WithdrawController extends Controller
{
    public function store(Request $request)
    {

        $account = Account::where('user_id', auth()->user()->id)->first()->makeVisible('password');

        if(!Hash::check($request['password'], $account->password))
        {
            return response()->json(["msg" => "Senha incorreta"]);
        }
        elseif(!$account->balance >= $request['withdraw'])
        {
            return response()->json(["msg" => "Voce nao tem saldo para fazer esse saque"]);
        }
        else
        {
            $account->balance = $account->balance - $request['withdraw'];
            if($account->save())
            {
                $withdraw = new Withdraw();
                $withdraw->account_id = $account->id;
                $withdraw->amount = $request['withdraw'];
                $withdraw->save();
                return response()->json(["msg" => "Saque Realizado com sucesso"]);
            }
        }
    }
}
