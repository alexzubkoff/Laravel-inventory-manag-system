<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;

class OrderReceiptController extends Controller
{
    private $request;
    private $id;
    private $goodId;
    private $orderreceipt;
    private $goodPrice;

    public function index()
    {
        $orderreceipts = DB::select('
                      select
                            orderreceipt.id as orderID,
                            goods.id as goodID,
                            goods.name as name,
                            goods.quantity as balancebegin,
                            orderreceipt.quantity as orderreceipt,
                            orderreceipt.price,
                            orderreceipt.quantity*orderreceipt.price as totalSum,
                            counterparties.name as provider,
                            counterparties.phonenumber,
                            counterparties.email,
                            orderreceipt.dateReceipt 
                      from orderreceipt
                      inner join counterparties
                      on orderreceipt.counterpartyId = counterparties.id
                      inner join orderreceiptgoods
                      on orderreceiptgoods.orderreceiptId = orderreceipt.id
                      inner join goods 
                      on orderreceiptgoods.goodId = goods.id');
        return view('orderreceipt_view',['orderreceipts'=>$orderreceipts]);
    }

    public function create(Request $request)
    {
        $this->request = $request;

        if ($request->method()=="GET"){
            $suppliers = DB::select('select id,name from counterparties where type = "provider"');
            $goods = DB::select('select id,name from goods');
            return view('orderreceipt_create_view',['suppliers'=>$suppliers,'goods'=>$goods]);
        }else{

            DB::transaction(function () {
                DB::insert('insert into orderreceipt (counterpartyId,dateReceipt,quantity,price,totalSum) values (?, ?, ?, ?, ?)',
                    [$this->request->input("supplierslist"),date("Y-m-d H:i:s"), $this->request->input("quantity"),$this->request->input("price"),$this->request->input("totalSum")]);

                $id = DB::select('SELECT MAX(id) as maxId FROM orderreceipt');
                $id = (array)$id[0];

                DB::insert('insert into orderreceiptgoods (orderreceiptId,goodId) values (?, ?)',
                    [$id ['maxId'], $this->request->input("goodslist")]);

                $good = DB::select('select * from goods where id = ?',[$this->request->input("goodslist")]);

                $goodArr = (array)$good[0];
                $newProdBalanceQuantity = (int)$goodArr['quantity'] + (int)$this->request->input("quantity");
                DB::table('goods')
                    ->where('id', $this->request->input("goodslist"))
                    ->update(['quantity' => $newProdBalanceQuantity,'price' => $this->request->input('price')]);
            });

        }
        return redirect('/orderreceipt');

    }

    public function delete($id,$goodid,$orderreceipt,$goodPrice)
    {
        $this->id = $id;
        $this->goodId = $goodid;
        $this->orderreceipt = $orderreceipt;
        $this->goodPrice = $goodPrice;

        DB::transaction(function () {

            DB::delete('delete from orderreceiptgoods where orderreceiptId = ? and goodid = ?',[$this->id,$this->goodId]);
            DB::delete('delete from orderreceipt where id = ?',[$this->id]);

            $good = DB::select('select * from goods where id = ?',[$this->goodId]);
            $goodArr = (array)$good[0];

            if ($goodArr['quantity']>1){
                $goodArr['quantity'] = $goodArr['quantity'] - $this->orderreceipt;
                DB::table('goods')
                    ->where('id', $this->goodId)
                    ->update(['quantity' =>  $goodArr['quantity'],'price' => $this->goodPrice]);
            }else{
                DB::delete('delete from goods where id = ?',[$this->id]);
            }
        });

            return redirect('/orderreceipt');
    }

}