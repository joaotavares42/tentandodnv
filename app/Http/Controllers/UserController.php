<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use http\Env\Response;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Account;
use App\Models\Address;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function store(StoreUserRequest $request)
    {

        $user = new User();
        $birth_date = $request['person']['birth_date'];
        $user->fill($request->all()['person']);

        $user->birth_date =  Carbon::createFromFormat('d/m/Y' ,$birth_date)->format('Y-m-d');
        $user->password = Hash::make($user->password);

        if(!$user->save()){
            return response()->json([
                "message" => "Usuário não foi salvo"
            ],500);
        }
        $account = new Account();
        $account->fill($request->all()['account']);
        $account->password = Hash::make($account->password);
        $account->user_id = $user->id;
        $account->save();
        $address = new Address();
        $address->user_id = $user->id;
        $address->fill($request->all()['address']);
        $address->save();
        return response()->json([
            'msg' => 'Conta criada com sucesso',
            'data' => [
                'user' => $user,
                'account' => $account
            ]
        ]);
    }
    public function logoutApi()
    {
        if (Auth::check()) {
            if(!Auth::user()->AauthAccessToken()->delete()){
                return response()->json(['msg' => 'Não foi possivel realizar o logout'],400);
            }
        }

    }
    public function disable(Request $request)
    {
        $user = Auth::user();
        $account = Account::where('user_id', auth()->user()->id)->first()->makeVisible('password');
        if(!Hash::check($request['password'], $account->password))
        {
            return response()->json(["msg" => "Senha incorreta"]);
        }
        elseif($account['balance'] > 0)
        {
            return response()->json(['msg' => 'Voce precisa estar com o saldo zerado para conseguir desativar  sua conta']);
        }
        $account->active = false;
        $user->deleted_at = now();
        $account->save();
        $this->logoutApi();
        if($user->save())
        {
            return response()->json(['msg' => 'Sua conta foi desativada com sucesso! Caso precise reativa-la por favor entre em contato como o nosso suporte!']);
        }
    }
    public function update(Request $request)
    {
        $user = Auth::user();
        $account = Auth::user()->account()->first()->makeVisible('password');
        $address = Auth::user()->address()->first();
        if(!Hash::check($request['old_password'], $account->password))
        {
            return response()->json(["msg" => "Senha incorreta"]);
        }
        if(isset($request['person']) && isset($request['person']['email']))
        {
            $user->email = $request['person']['email'];
        }
        if(isset($request['person']) && isset($request['person']['telephone']))
        {
            $user->telephone = $request['person']['telephone'];
        }
        if(isset($request['account']['new_password']))
        {
            $account->password = Hash::make($request['account']['new_password']);
        }
        $address->fill($request->all()['address']);
        $user->save();
        $account->save();
        $address->save();
        return response()->json(['msg' => 'Dados alterado com sucesso', 'date' =>['user' => $user, 'address' => $address]]);
    }
}
