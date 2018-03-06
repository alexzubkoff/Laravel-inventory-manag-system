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

              if (!empty($goodsarr) && is_array($goodsarr)) {

                  foreach ($goodsarr as $product){

                      $good = Good::updateOrCreate(
                          ['name' => $product['name']],
                          ['quantity' => $product['quantity'],'price' => $product['price']]
                      );




                      /*var_dump($product['name']);
                      $goodExists = Good::where('name','=',$product['name'])->get();
                      var_dump(empty($goodExists));
                      exit();
                      if (empty($goodExists)){

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
                          $newProdBalanceQuantity = $goodExists->quantity + (int)$product['quantity'];
                          $good = Good::where('id','=',$goodExists->id)->get();
                          var_dump($good);
                          $good->quantity = $newProdBalanceQuantity;
                          var_dump($good->quantity);
                          exit();
                          $good->price = $this->request->price;
                          $good->save();

                          $purchase = Purchase::where('productId','=',$goodExists->id)->get();
                          $purchase->delete();

                          $purchase = new Purchase;
                          $purchase->counterpartyId = $product['provider'];
                          $purchase->productId = $good->id;
                          $purchase->stockBalance = $newProdBalanceQuantity;
                          $purchase->purchaseQuantity = $product['quantity'];
                          $purchase->purchaseDate = date("Y-m-d H:i:s");
                          $purchase->save();
                      }*/
                  }
              }else {
                      $good = Good::where('name','=',$this->request->name)->get();

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