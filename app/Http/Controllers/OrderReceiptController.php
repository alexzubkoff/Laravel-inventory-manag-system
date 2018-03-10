<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use App\Counterparty;
use App\Good;
use App\Purchase;

class OrderReceiptController extends Controller
{
    private $request;
    private $id;
    private $goodId;

    public function index()
    {
        $orderreceipts = DB::select('
                                SELECT purchases.id as purchaseId,goods.id as productId,goods.name as productName,
                                goods.price,purchases.stockBalance,purchases.purchaseQuantity,counterparties.name as provider,
                                counterparties.phonenumber,counterparties.email,purchases.purchaseDate FROM goods
                                INNER JOIN purchases ON goods.id=purchases.productId INNER JOIN counterparties
                                ON purchases.counterpartyId=counterparties.id 
                                 ');

        $suppliers = Counterparty::where('type','=','provider')->get();

        return view('orderreceipt_view',['orderreceipts'=>$orderreceipts,'suppliers'=>$suppliers]);
    }

    public function create(Request $request)
    {
        $this->request = $request;

           DB::transaction(function () {

               $goodsarr = json_decode($this->request->goodsarr, true);

              if (!empty($goodsarr)) {

                  foreach ($goodsarr as $product){

                      $goodsExists = Good::where('name','=',$product['name'])->get()->first();

                      if (empty($goodsExists)){
                          $good = new Good;
                          $good->name = $product['name'];
                          $good->quantity =  $product['quantity'];
                          $good->price = $product['price'];
                          $good->save();

                          $purchase = new Purchase;
                          $purchase->counterpartyId = $product['provider'];
                          $purchase->productId = $good->id;
                          $purchase->purchaseQuantity = $product['quantity'];
                          $purchase->purchaseDate = date("Y-m-d H:i:s");
                          $purchase->save();
                      }else {
                          $good = Good::find($goodsExists->id);
                          $good->quantity = $goodsExists->quantity + $product['quantity'];
                          $good->price = $product['price'];
                          $good->save();

                          $purchase = Purchase::where('productId','=',$goodsExists->id)->get()->first();
                          $purchase->delete();

                          $purchase = new Purchase;
                          $purchase->counterpartyId = $product['provider'];
                          $purchase->productId = $good->id;
                          $purchase->stockBalance = $good->quantity;
                          $purchase->purchaseQuantity = $product['quantity'];
                          $purchase->purchaseDate = date("Y-m-d H:i:s");
                          $purchase->save();
                      }
                  }
              }else {
                      $goodsExists = Good::where('name','=',$this->request->name)->get()->first();
                      if (empty($goodsExists)){
                          $good = new Good;
                          $good->name = $this->request->name;
                          $good->quantity =   $this->request->quantity;
                          $good->price = $this->request->price;
                          $good->save();

                          $purchase = new Purchase;
                          $purchase->counterpartyId = $this->request->input("supplierslist");
                          $purchase->productId = $good->id;
                          $purchase->purchaseQuantity = $this->request->quantity;
                          $purchase->purchaseDate = date("Y-m-d H:i:s");
                          $purchase->save();
                      }else {
                          $good = Good::find($goodsExists->id);
                          $good->quantity = $goodsExists->quantity + $this->request->quantity;
                          $good->price = $this->request->price;
                          $good->save();

                          $purchase = Purchase::where('productId','=',$goodsExists->id)->get()->first();
                          $purchase->delete();

                          $purchase = new Purchase;
                          $purchase->counterpartyId = $this->request->input("supplierslist");
                          $purchase->productId = $good->id;
                          $purchase->stockBalance = $good->quantity;
                          $purchase->purchaseQuantity = $this->request->quantity;
                          $purchase->purchaseDate = date("Y-m-d H:i:s");
                          $purchase->save();
                      }
              }


            });

        return redirect('/orderreceipt');

    }

    public function delete($purchaseId,$productId)
    {
        $this->id = $purchaseId;
        $this->goodId = $productId;

        DB::transaction(function () {
            $purchase = Purchase::find($this->id);
            $purchase->delete();
            $good = Good::find($this->goodId);
            $good->delete();
        });

            return redirect('/orderreceipt');
    }

}