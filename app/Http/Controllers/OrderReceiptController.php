<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;

class OrderReceiptController extends Controller
{

    public function index()
    {
        $orderreceipts = DB::select('
                      select
                            orderreceipt.id as orderID,
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
        if ($request->method()=="GET"){
            return view('counterparties_create_view');
        }else{
            DB::insert('insert into counterparties (type,name,phonenumber,email) values (?, ?,?,?)', [$request->type, $request->name,$request->phonenumber,$request->email]);
            return redirect('/counterparties');
        }

    }

    public function delete($id)
    {
        DB::delete('delete from counterparties where id = ?',[$id]);
        return redirect('/counterparties');
    }

}