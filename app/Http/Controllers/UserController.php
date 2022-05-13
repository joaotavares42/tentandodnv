<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Account;
use App\Models\Address;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function store(Request $request)
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
}
