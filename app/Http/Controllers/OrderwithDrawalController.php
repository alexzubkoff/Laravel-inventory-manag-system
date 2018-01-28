<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;

class OrderwithDrawalController extends Controller
{
    private $request;
    private $id;
    private $goodId;
    private $orderreceipt;
    private $goodPrice;

    public function index()
    {
        $orderwithdrawal = DB::select('
                      SELECT orders.id as orderId,goods.id as productId,goods.name as productName,goods.price,orders.stockBalance,orders.orderQuantity,counterparties.name as buyer,
                      counterparties.phonenumber,counterparties.email,orders.orderDate FROM goods
                      INNER JOIN orders ON goods.id=orders.productId INNER JOIN counterparties
                      ON orders.counterpartyId=counterparties.id ');
        $suppliers = DB::select('select id,name from counterparties where type = "buyer"');
        $goods = DB::select('SELECT goods.id,goods.name,goods.quantity FROM goods WHERE goods.quantity>0');
        return view('orderwithdrawal_view',['orderwithdrawals'=>$orderwithdrawal,'suppliers'=>$suppliers,'goods'=>$goods]);
    }

    public function create(Request $request)
    {
        $this->request= $request;

        DB::transaction(function () {

            $good = DB::select('select * from goods where id=?',[$this->request->input('goodslist')]);

                $goodArr = (array)$good[0];
                if ($goodArr['quantity']>=$this->request->input("quantity")){
                    $newProdBalanceQuantity = (int)$goodArr['quantity'] - (int)$this->request->input("quantity");
                    DB::table('goods')
                        ->where('id', $goodArr['id'])
                        ->update(['quantity' => $newProdBalanceQuantity,'price' => $this->request->price]);
                        DB::insert('insert into orders (counterpartyId,productId,stockBalance,orderQuantity,orderDate) values (?, ?, ? ,?,?)',
                        [$this->request->input("supplierslist"),$this->request->input('goodslist'),$goodArr['quantity'], $this->request->quantity,date("Y-m-d H:i:s")]);
                }else{
                    $newProdBalanceQuantity = (int)$goodArr['quantity']-(int)$goodArr['quantity'];
                    DB::table('goods')
                        ->where('id', $goodArr['id'])
                        ->update(['quantity' => $newProdBalanceQuantity,'price' => $this->request->price]);
                    DB::insert('insert into orders (counterpartyId,productId,stockBalance,orderQuantity,orderDate) values (?, ?, ? ,?,?)',
                        [$this->request->input("supplierslist"),$this->request->input('goodslist'),$goodArr['quantity'], $this->request->quantity,date("Y-m-d H:i:s")]);
                }

        });
        return redirect('/orderwithdrawal');

    }

    public function delete($id,$goodid)
    {
        $this->id = $id;
        $this->goodId = $goodid;

        DB::transaction(function () {
                DB::delete('delete from orders where id = ?',[$this->id]);
                DB::delete('delete from goods where id = ?',[$this->goodId]);
        });

        return redirect('/orderwithdrawal');
    }

}