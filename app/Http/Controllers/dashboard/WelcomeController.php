<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\dashboard\Resturant;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index(){
        $returants = Resturant::all();
        return view('dashboard.welcome',compact('returants'));
    }
}
