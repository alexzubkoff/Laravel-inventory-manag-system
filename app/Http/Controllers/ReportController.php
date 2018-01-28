<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function create(Request $request)
    {
        $this->request= $request;

        if ($this->request->method()=='GET') {
            $report = DB::select('
                                SELECT goods.id as productId,goods.name as productName,goods.price,purchases.stockBalance as purchasBalance,purchases.purchaseQuantity,
                                counterparties.name as provider, purchases.purchaseDate,orders.stockBalance,orders.orderQuantity,orders.orderDate, 
                                orders.stockBalance-orders.orderQuantity as balance FROM goods INNER JOIN purchases ON goods.id=purchases.productId 
                                INNER JOIN counterparties ON purchases.counterpartyId=counterparties.id  INNER JOIN orders ON goods.id=orders.productId AND 
                                purchases.purchaseDate<=orders.orderDate 
                                 ');
            return view('report_view', ['reports' => $report]);

        }else{
                if (!empty($this->request->input('datebegin') && !empty($this->request->input('dateend')))){

                    $dateBegin = $this->request->input('datebegin').'%';
                    $dateEnd =  $this->request->input('dateend').'%';

                    $report = DB::select('SELECT goods.id as productId,goods.name as productName,goods.price,purchases.stockBalance as purchasBalance,purchases.purchaseQuantity,
                                counterparties.name as provider, purchases.purchaseDate,orders.stockBalance,orders.orderQuantity,orders.orderDate, 
                                orders.stockBalance-orders.orderQuantity as balance FROM goods INNER JOIN purchases ON goods.id=purchases.productId 
                                INNER JOIN counterparties ON purchases.counterpartyId=counterparties.id  INNER JOIN orders ON goods.id=orders.productId AND
                                purchases.purchaseDate<=orders.orderDate AND orders.orderDate BETWEEN ? AND ?',[$dateEnd,$dateBegin]);

                        return view('report_view', ['reports' => $report, 'dateBegin' =>$this->request->input('datebegin')]);
                }else{

                    $date = $this->request->input('datebegin').'%';
                    $report = DB::select('
                                SELECT goods.id as productId,goods.name as productName,goods.price,purchases.stockBalance as purchasBalance,purchases.purchaseQuantity,
                                counterparties.name as provider, purchases.purchaseDate,orders.stockBalance,orders.orderQuantity,orders.orderDate, 
                                orders.stockBalance-orders.orderQuantity as balance FROM goods INNER JOIN purchases ON goods.id=purchases.productId 
                                INNER JOIN counterparties ON purchases.counterpartyId=counterparties.id  INNER JOIN orders ON goods.id=orders.productId AND 
                                purchases.purchaseDate<=orders.orderDate AND orders.orderDate LIKE ?',[$date]);
                    return view('report_view', ['reports' => $report,'dateBegin' =>$this->request->input('datebegin')]);
                }

        }

    }

}