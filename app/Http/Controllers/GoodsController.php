<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use App\Good;


class GoodsController extends Controller
{

    public function index()
    {
        $goods = Good::all();
        return view('goods_view',['goods'=>$goods]);
    }

    public function create(Request $request)
    {
        $good = new Good;
        $good->name = $request->name;
        $good->quantity = $request->quantity;
        $good->price = $request->price;
        $good->save();
        return redirect('/goods');
    }

    public function update(Request $request,$id)
    {
        if ($request->method()=="GET"){
            $good= Good::find($id);
            return view('goods_update_view',['good'=>$good]);
        }else{
            $good= Good::find($id);
            $good->name = $request->name;
            $good->quantity = $request->quantity;
            $good->price = $request->price;
            $good->save();
            return redirect('/goods');
        }
    }

    public function delete($id)
    {
        $good= Good::find($id);
        $good->delete();
        return redirect('/goods');
    }
}
