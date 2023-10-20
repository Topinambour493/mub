<?php

namespace App\Http\Controllers;
use App\Models\Panier;
use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PanierController extends Controller
{
    public function panier(){
        return view('panier');
    }


    //Fonction qui utilise l'ajax pour calculer le nombre de commande total
    public function get_nbCommandes(){
        $commandes= Panier::select('user_id','commande')->get()->groupBy('user_id');
        $NBcom=0;
        foreach ($commandes as $commande ){
            $NBcom += $commande[count($commande)-1]->commande;
        }
        return  $NBcom;
    }

    // Fonction qui permet de valider le panier 
    public function validerlepanier(Request $request){
        $paniers=Panier::select('*')
        ->where('user_id',Auth::user()->id)
        ->where('commande',Auth::user()->commande_en_cours)->get();


        foreach ($paniers as $panier ){
            $user=Auth::user();
            $user->commande_en_cours+=1;
            $user->save();
            return "catalogue";
        }
        return "panier";
    }


    // Fonction qui ajoute au panier le produit avec la bonne valeur  depuis la fiche du produit
    public function ajoutePanier(Request $request){
        $panier_produit = json_decode($request['produit']);
        $panier=[
            'commande'=>Auth::user()->commande_en_cours,
            'user_id'=>Auth::user()->id,
            'produit_id'=>$panier_produit->{'id'},
            'quantite'=> $panier_produit->{'quantite'}
        ];

        $produit=Produit::find($panier_produit->{'id'});
        $produit->save();

        Panier::create($panier);
    }


    // Fonction qui enleve le stock avec l'aide de l'ajax 
    public function enleveStock(Request $request){
        $panier_produit = json_decode($request['produit']);
        $produit=Produit::find($panier_produit->{'id'});
        $produit->stock-=$panier_produit->{'quantite'};
        $produit->save();
    }

// Fonction qui remet le stock
    public function remetStock(Request $request){
        $panier_produit = json_decode($request['produit']);
        $produit=Produit::find($panier_produit->{'id'});
        $produit->stock+=$panier_produit->{'quantite'};
        $produit->save();
    }

    public function getStock(Request $request){
        $panier_produit = json_decode($request['produit']);
        $produit=Produit::find($panier_produit->{'id'});
        return $produit->stock;

    }
// Fonction qui va chercher la plus grosse commande en terme de quantité
    public function biggestpurchase()
    {
        $big=DB::table('paniers')
        ->orderBy('quantite','DESC')        
        ->first();
        return response()->json($big);
        
    }
    
}

