<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;

class OrderReceiptController extends Controller
{
    private $request;
    private $id;
    private $goodId;

    public function index()
    {
        $orderreceipts = DB::select('
                                SELECT purchases.id as purchaseId,goods.id as productId,goods.name as productName,goods.price,purchases.stockBalance,purchases.purchaseQuantity,counterparties.name as provider,
                                counterparties.phonenumber,counterparties.email,purchases.purchaseDate FROM goods
                                INNER JOIN purchases ON goods.id=purchases.productId INNER JOIN counterparties
                                ON purchases.counterpartyId=counterparties.id 
                                 ');

        $suppliers = DB::select('select id,name from counterparties where type = "provider"');

        return view('orderreceipt_view',['orderreceipts'=>$orderreceipts,'suppliers'=>$suppliers]);
    }

    public function create(Request $request)
    {
        $this->request = $request;

            DB::transaction(function () {

                $good = DB::select('select * from goods where name=?',[$this->request->name]);

                if (empty($good)){
                    DB::insert('insert into goods (name,quantity,price) values (?, ?,?)',[$this->request->name, $this->request->quantity,$this->request->price]);

                    $id = DB::select('SELECT MAX(id) as maxId FROM goods');
                    $id = (array)$id[0];

                    DB::insert('insert into purchases (counterpartyId,productId,purchaseQuantity,purchaseDate) values (?, ?, ? ,? )',
                        [$this->request->input("supplierslist"),$id['maxId'],$this->request->quantity, date("Y-m-d H:i:s")]);
                }else {
                    $goodArr = (array)$good[0];
                    $newProdBalanceQuantity = (int)$goodArr['quantity'] + (int)$this->request->input("quantity");
                    DB::table('goods')
                        ->where('id', $goodArr['id'])
                        ->update(['quantity' => $newProdBalanceQuantity,'price' => $this->request->price]);
                    DB::delete('delete from purchases where productId = ?',[ $goodArr['id']]);
                    DB::insert('insert into purchases (counterpartyId,productId,stockBalance,purchaseQuantity,purchaseDate) values (?, ?, ? ,?,? )',
                        [$this->request->input("supplierslist"),$goodArr['id'],(int)$goodArr['quantity'],$this->request->quantity, date("Y-m-d H:i:s")]);

                }

            });


        return redirect('/orderreceipt');

    }

    public function delete($purchaseId,$productId)
    {
        $this->id = $purchaseId;
        $this->goodId = $productId;

        DB::transaction(function () {
            DB::delete('delete from purchases where id = ?',[$this->id]);
            DB::delete('delete from goods where id = ?',[$this->goodId]);


        });

            return redirect('/orderreceipt');
    }

}