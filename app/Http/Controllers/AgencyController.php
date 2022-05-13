<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agency;

class AgencyController extends Controller
{
    public function index()
    {
        $agencies = Agency::all();

        return response()->json($agencies);
    }

    public function store(Request $request)
    {
        $agency =  new Agency();

        $agency->fill($request->all());

        $agency->save();

        return ['msg' => 'agencia criada'];
    }
}
