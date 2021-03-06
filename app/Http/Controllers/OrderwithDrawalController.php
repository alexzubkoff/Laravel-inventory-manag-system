<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use App\Counterparty;
use App\Good;
use App\Order;

class OrderwithDrawalController extends Controller
{
    private $request;
    private $id;
    private $goodId;

    public function index()
    {
        $orderwithdrawal = DB::select('
                      SELECT orders.id as orderId,goods.id as productId,goods.name as productName,goods.price,orders.stockBalance,orders.orderQuantity,counterparties.name as buyer,
                      counterparties.phonenumber,counterparties.email,orders.orderDate FROM goods
                      INNER JOIN orders ON goods.id=orders.productId INNER JOIN counterparties
                      ON orders.counterpartyId=counterparties.id ');

        $suppliers = Counterparty::where('type','=','buyer')->get();
        $goods = Good::where('quantity','>','0')->get();

        return view('orderwithdrawal_view',['orderwithdrawals'=>$orderwithdrawal,'suppliers'=>$suppliers,'goods'=>$goods]);
    }

    public function create(Request $request)
    {
        $this->request= $request;

        DB::transaction(function () {

            $good = Good::find($this->request->input('goodslist'));

                if ($good->quantity >= $this->request->input("quantity")){
                    $newProdBalanceQuantity = $good->quantity - (int)$this->request->input("quantity");
                    $good->quantity = $newProdBalanceQuantity;
                    $good->price = $this->request->price;
                    $good->save();

                    $order = new Order;
                    $order->counterpartyId = $this->request->input("supplierslist");
                    $order->productId = $this->request->input('goodslist');
                    $order->stockBalance = $newProdBalanceQuantity;
                    $order->orderQuantity = $this->request->quantity;
                    $order->orderDate = date("Y-m-d H:i:s");
                    $order->save();
                }else{
                    $newProdBalanceQuantity = $good->quantity - $good->quantity;
                    $good->quantity = $newProdBalanceQuantity;
                    $good->price = $this->request->price;
                    $good->save();

                    $order = new Order;
                    $order->counterpartyId = $this->request->input("supplierslist");
                    $order->productId = $this->request->input('goodslist');
                    $order->stockBalance = $newProdBalanceQuantity;
                    $order->orderQuantity = $this->request->quantity;
                    $order->orderDate = date("Y-m-d H:i:s");
                    $order->save();
                }

        });
        return redirect('/orderwithdrawal');

    }

    public function delete($id,$goodid)
    {
        $this->id = $id;
        $this->goodId = $goodid;

        DB::transaction(function () {
                $order = Order::find($this->id);
                $order->delete();
                $good = Good::find($this->goodId);
                $good->delete();
        });

        return redirect('/orderwithdrawal');
    }

}