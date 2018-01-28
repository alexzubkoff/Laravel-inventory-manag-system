<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;



class GoodsController extends Controller
{

    public function index()
    {
        $goods = DB::select('select * from goods');
        return view('goods_view',['goods'=>$goods]);
    }

    public function create(Request $request)
    {

        DB::insert('insert into goods (name,quantity,price) values (?, ?,?)',[$request->name, $request->quantity,$request->price]);
        return redirect('/goods');
    }

    public function update(Request $request,$id)
    {
        if ($request->method()=="GET"){
            $good= DB::select('select * from goods where id = ?', [$id]);
            return view('goods_update_view',['good'=>(array)$good[0]]);
        }else{
            DB::table('goods')
                ->where('id', $request->input('id'))
                ->update(['name' => $request->input('name'),'quantity' => $request->input('quantity'),'price' => $request->input('price')]);
            return redirect('/goods');
        }
    }

    public function delete($id)
    {
        DB::delete('delete from goods where id = ?',[$id]);
        return redirect('/goods');
    }
}
