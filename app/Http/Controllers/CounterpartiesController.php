<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use App\Counterparty;

class CounterpartiesController extends Controller
{
    public function index()
    {
        $counterparties = Counterparty::all();
        return view('counterparties_view',['counterparties'=>$counterparties]);
    }
    public function create(Request $request)
    {
            $counterparty = new Counterparty;
            $counterparty->type = $request->type;
            $counterparty->name = $request->name;
            $counterparty->phonenumber = $request->phonenumber;
            $counterparty->email = $request->email;
            $counterparty->save();
            return redirect('/counterparties');
    }

    public function update(Request $request,$id)
    {
        if ($request->method()=="GET"){
            $counterparty= Counterparty::find($id);
            return view('counterparties_update_view',['counterparty'=>$counterparty]);
        }else{
            $counterparty= Counterparty::find($id);
            $counterparty->type = $request->type;
            $counterparty->name = $request->name;
            $counterparty->phonenumber = $request->phonenumber;
            $counterparty->email = $request->email;
            $counterparty->save();
            return redirect('/counterparties');
        }
    }

    public function delete($id)
    {
        $counterparty= Counterparty::find($id);
        $counterparty->delete();
        return redirect('/counterparties');
    }
}