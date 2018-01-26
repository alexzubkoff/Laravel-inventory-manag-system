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
                      select
                            orderwithdrawal.id as orderID,
                            goods.id as goodID,
                            goods.name as name,
                            goods.quantity as balancebegin,
                            orderwithdrawal.quantity as orderwithdrawal,
                            orderwithdrawal.price,
                            orderwithdrawal.quantity*orderwithdrawal.price as totalSum,
                            counterparties.name as buyer,
                            counterparties.phonenumber,
                            counterparties.email,
                            orderwithdrawal.dateWithdrawal 
                      from orderwithdrawal
                      inner join counterparties
                      on orderwithdrawal.counterpartyId = counterparties.id
                      inner join orderwithdrawalgoods
                      on orderwithdrawalgoods.orderwithdrawalId =orderwithdrawal.id
                      inner join goods 
                      on orderwithdrawalgoods.goodId = goods.id');
        return view('orderwithdrawal_view',['orderwithdrawals'=>$orderwithdrawal]);
    }

    public function create(Request $request)
    {
        $this->request = $request;

        if ($request->method()=="GET"){
            $suppliers = DB::select('select id,name from counterparties where type = "buyer"');
            $goods = DB::select('select id,name from goods');
            return view('orderwithdrawal_create_view',['suppliers'=>$suppliers,'goods'=>$goods]);
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