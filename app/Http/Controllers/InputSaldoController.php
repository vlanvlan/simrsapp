<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InputSaldo;

class InputSaldoController extends Controller
{
    public function index()
    {
        $input_saldos = InputSaldo::with('bankAccount')->get();
        return view('input_saldo.index', compact('input_saldos'));
    }
}
