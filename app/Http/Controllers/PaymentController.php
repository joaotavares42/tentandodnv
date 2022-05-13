<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePaymentRequest;
use App\Models\Account;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function index()
    {
        $conta = Auth::user()->account()->first();
        $payments = Payment::where('account_id', $conta->id)->get();

        return response()->json(['data' => $payments, 'msg' => 'Esse são os seus boletos'], 200);
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $conta = Auth::user()->account()->first();

        if($user->document_type == 'CPF')
        {
            return response()->json(['Voce nao tem permissao para registrar um boleto']);
        }
        else
        {
            $numboleto = rand(10000,99999);
            $payment = new Payment();
            $payment->amount = $request->amount;
            $payment->account_id = $conta->id;
            $payment->payment_number = $numboleto;
            $payment->save();
            return $this->index();
        }
    }

    public  function update(UpdatePaymentRequest $request)
    {
        $account = Auth::user()->account()->first();
        $payment = Payment::where('payment_number', $request->payment_number)->first();
        if(!Hash::check($request['password'], $account->password))
        {
            return response()->json(["msg" => "Senha incorreta"]);
        }
        elseif($account->id == $payment->account_id)
        {
            return response()->json(["msg" => "Esse boleto foi gerado por voce"]);
        }
        elseif($account->balance < $payment->amount)
        {
            return response()->json(["msg" => "Voce nao tem saldo para pagar esse boleto"]);
        }
        elseif(!$payment->status)
        {
            $account->balance = $account->balance - $payment->amount;
            $payment_owner = Account::where('id', $payment->account_id)->first();
            $payment_owner->balance = $payment_owner->balance + $payment->amount;
            if ($account->save() && $payment_owner->save())
            {
                $payment->status = true;
                $payment->payer_account_id = $account->id;
                $payment->save();

                return response()->json(['msg' => 'Pagamento realizado com sucesso']);
            }
        }
        else
        {
            return response()->json(['msg' => 'O boleto ja esta pago']);
        }
    }
}
