<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;

class GoodslistController extends Controller
{
    public function index()
    {
        $goods = DB::select('select * from goodslist');
        return view('goodslist_view',['goods'=>$goods]);
    }

    public function autocomplete(Request $request)
    {
            $term = $request->term;

            $results = [];

            $queries = DB::table('goodslist')
                ->where('name', 'LIKE', $term . '%')
                ->take(5)->get();

            foreach ($queries as $query) {
                $results[] = [$query->name];
            }

            return json_encode($results);
    }


    public function create(Request $request)
    {

        DB::insert('insert into goodslist (name,price) values (?, ?)',[$request->name,$request->price]);
        return redirect('/goodslist');
    }

    public function update(Request $request,$id)
    {
        if ($request->method()=="GET"){
            $good= DB::select('select * from goodslist where id = ?', [$id]);
            return view('goodslist_update_view',['good'=>(array)$good[0]]);
        }else{
            DB::table('goodslist')
                ->where('id', $request->input('id'))
                ->update(['name' => $request->input('name'),'price' => $request->input('price')]);
            return redirect('/goodslist');
        }
    }

    public function delete($id)
    {
        DB::delete('delete from goodslist where id = ?',[$id]);
        return redirect('/goodslist');
    }

}