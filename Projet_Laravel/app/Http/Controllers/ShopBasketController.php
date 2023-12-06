<?php

namespace App\Http\Controllers;
use App\Models\ShopBasket;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ShopBasketController extends Controller
{
    public function shopBasket(){
        return view('panier');
    }


    //Fonction qui utilise l'ajax pour calculer le nombre de commande total
    public function getNumberOrder(){
        $orders= shopBasket::select('user_id','commande')->get()->groupBy('user_id');
        $numberOrder=0;
        foreach ($orders as $order ){
            $numberOrder += $order[count($order)-1]->commande;
        }
        return  $numberOrder;
    }

    // Fonction qui permet de valider le panier
    public function validateShopBasket(Request $request){
        $shopBasket=shopBasket::select('*')
        ->where('user_id',Auth::user()->id)
        ->where('order',Auth::user()->current_order)->get();


        foreach ($shopBasket as $SB ){
            $user=Auth::user();
            $user->current_order+=1;
            $user->save();
            return "catalog";
        }
        return "panier";
    }


    // Fonction qui ajoute au panier le produit avec la bonne valeur  depuis la fiche du produit
    public function addShopBasket(Request $request){
        $shopBasketProduct = json_decode($request['produit']);
        if ($shopBasketProduct->{'quantite'} < 1){
            return response()->json(array('message'=>'la quantité ne peut pas être inférieur à 1'), 400);
        }
        $shopBasket=[
            'order'=>Auth::user()->current_order,
            'user_id'=>Auth::user()->id,
            'product_id'=>$shopBasketProduct->{'id'},
            'quantity'=> $shopBasketProduct->{'quantite'}
        ];

        $product=Product::find($shopBasketProduct->{'id'});
        $product->save();

        shopBasket::create($shopBasket);
    }


    // Fonction qui enleve le stock avec l'aide de l'ajax
    public function removeStock(Request $request){
        $shopBasketProduct = json_decode($request['product']);
        $product=Product::find($shopBasketProduct->{'id'});
        $product->stock-=$shopBasketProduct->{'quantity'};
        $product->save();
    }

// Fonction qui remet le stock
    public function restock(Request $request){
        $shopBasketProduct = json_decode($request['produit']);
        $product=Product::find($shopBasketProduct->{'id'});
        $product->stock+=$shopBasketProduct->{'quantite'};
        $product->save();
    }

    public function getStock(Request $request){
        $panier_produit = json_decode($request['produit']);
        $produit=Product::find($panier_produit->{'id'});
        return $produit->stock;

    }
// Fonction qui va chercher la plus grosse commande en terme de quantité
    public function biggestPurchase()
    {
        $big=DB::table('paniers')
        ->orderBy('quantite','DESC')
        ->first();
        return response()->json($big);

    }

}

