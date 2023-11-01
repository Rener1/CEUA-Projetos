<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function home()
    {
        if(Auth::user()->hasRole('Administrador')){
            return redirect()->route('solicitacao.admin.index');
        }
        return view('home');
    }
}
