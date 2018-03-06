<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use App\GoodList;

class GoodslistController extends Controller
{
    public function index()
    {
        $goods = GoodList::all();
        return view('goodslist_view',['goods'=>$goods]);
    }

    public function create(Request $request)
    {
        $good = new GoodList;
        $good->name = $request->name;
        $good->price = $request->price;
        $good->save();
        return redirect('/goodslist');
    }

    public function update(Request $request,$id)
    {
        if ($request->method()=="GET"){
            $good= GoodList::find($id);
            return view('goodslist_update_view',['good'=>$good]);
        }else{
            $good= GoodList::find($id);
            $good->name = $request->name;
            $good->price = $request->price;
            $good->save();
            return redirect('/goodslist');
        }
    }

    public function delete($id)
    {
        $good = GoodList::find($id);
        $good->delete();
        return redirect('/goodslist');
    }

    public function autocomplete(Request $request)
    {
        $term = $request->term;

        $results = [];

        $queries = GoodList::where('name', 'LIKE', $term . '%')
            ->take(5)->get();

        foreach ($queries as $query) {
            $results[] = [$query->name];
        }

        return json_encode($results);
    }

}