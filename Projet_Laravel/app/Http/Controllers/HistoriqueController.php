<?php

namespace App\Http\Controllers;

use App\Models\Panier;
use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HistoriqueController extends Controller
{
    public function historiqueCommandes()
    {
        $commandes=array();
        for ($i = 1; $i < Auth::user()->commande_en_cours ; $i++){
            $commandes[$i] = Panier::select('*')
                            ->where('user_id',Auth::user()->id)
                            ->where('commande',$i)->get();
        }
        foreach ($commandes as $panierItems)
        {
            $total=0;
            foreach ($panierItems as $panierItem){
                $panierItem->stock_produit=($panierItem->quantite)+(Produit::find($panierItem->produit_id)->stock);
                $panierItem->nom_produit=Produit::find($panierItem->produit_id)->nom;
                $panierItem->prix=Produit::find($panierItem->produit_id)->prix;
                $total+=$panierItem->quantite*$panierItem->prix;
            }
            $panierItems->total_commande=$total;

        }

        return view('historique',compact('commandes'));
    }

}

