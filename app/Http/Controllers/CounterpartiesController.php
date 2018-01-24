<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;

class CounterpartiesController extends Controller
{
    public function index()
    {
        $counterparties = DB::select('select * from counterparties');
        return view('counterparties_view',['counterparties'=>$counterparties]);
    }

    public function create(Request $request)
    {
        if ($request->method()=="GET"){
            return view('counterparties_create_view');
        }else{
            DB::insert('insert into counterparties (type,name,phonenumber,email) values (?, ?,?,?)', [$request->type, $request->name,$request->phonenumber,$request->email]);
            return redirect('/counterparties');
        }

    }

    public function update(Request $request,$id)
    {
        if ($request->method()=="GET"){
            $counterparty= DB::select('select * from counterparties where id = ?', [$id]);
            return view('counterparties_update_view',['counterparty'=>(array)$counterparty[0]]);
        }else{
            DB::table('counterparties')
                ->where('id', $id)
                ->update(['type' => $request->type,'name' => $request->name,'phonenumber' => $request->phonenumber,'email' => $request->email]);
            return redirect('/counterparties');
        }
    }

    public function delete($id)
    {
        DB::delete('delete from counterparties where id = ?',[$id]);
        return redirect('/counterparties');
    }
}