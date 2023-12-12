<?php

namespace App\Http\Controllers;

use App\Models\ShopBasket;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    public function orderHistory()
    {
        $orders=array();
        for ($i = 1; $i < Auth::user()->current_order ; $i++){
            $orders[$i] = ShopBasket::select('*')
                            ->where('user_id',Auth::user()->id)
                            ->where('order',$i)->get();
        }
        $orders = array_reverse($orders);
        foreach ($orders as $order)
        {
            $total=0;
            foreach ($order as $shopBasketItem){
                $shopBasketItem->stock_product=($shopBasketItem->quantity)+(Product::find($shopBasketItem->product_id)->stock);
                $shopBasketItem->name_product=Product::find($shopBasketItem->product_id)->name;
                $shopBasketItem->price=Product::find($shopBasketItem->product_id)->price;
                $total+=$shopBasketItem->quantity*$shopBasketItem->price;
            }
            $order->total_order=$total;

        }

        return view('history',compact('orders'));
    }

}

