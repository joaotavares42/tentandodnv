<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTransferRequest;
use App\Models\Account;
use App\Models\Transfer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TransferController extends Controller
{
    public function store(StoreTransferRequest $request)
    {
        $from_account = Account::where('user_id', auth()->user()->id)->first()->makeVisible('password');
        if($from_account->account_number == $request['to_account'])
        {
            return response()->json(['Voce nao pode fazer uma transferencia para sua propria conta']);
        }
        elseif(!Hash::check($request['password'], $from_account->password))
        {
            return response()->json(["msg" => "Senha incorreta"]);
        }
        elseif($from_account->balance < $request['transfer'])
        {
            return response()->json(["msg" => "Voce nao tem saldo para fazer essa transferencia"]);
        }
        else
        {
            $from_account->balance = $from_account->balance - $request['transfer'];
            $from_account->save();
            $to_account = Account::where('account_number',$request['to_account'])->first();
            $to_account->balance = $to_account->balance + $request['transfer'];
            if($to_account->save())
            {
                $transfer  = new Transfer();
                $transfer->from_account_id = $from_account->id;
                $transfer->to_account_id = $from_account->id;
                $transfer->amount = $request['transfer'];
                $transfer->fill($request->all());
                $transfer->save();
                return response()->json(["msg" => "transferencia feita"]);
            }
        }
    }
}
