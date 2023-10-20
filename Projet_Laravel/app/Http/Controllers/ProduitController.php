<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produit;
use Illuminate\Support\Facades\Auth;

class ProduitController extends Controller
{
    public function catalogue()
    {
        $produits=Produit::all();

        return view('catalogue',[
            'produits' => $produits
        ]);
    }

    public function fiche_produit($id)
    {
        return view('fiche_produit',[
            'produit' => Produit::find($id)
        ]);
    }

    public function adminNouveauProduit()
    {
        return view('admin');
    }

    public function ajoutProduit(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|max:50',
            'prix' => 'required',
            'description' => 'required',
            'catégorie' => 'required|max:30',
            'image' => 'required',
            'stock' => 'required'
        ]);
        $filename=$request->file('image') ->getClientOriginalName() ;
        $filename=date("Y-m-dH:i:s") . $filename;
        //upload folder in a folder and adding dateTime for avoid name mismatch
        $request->file('image') -> storeAs('disk_de_merde', $filename, [ 'disk' => 'disk_de_merde']);
        //storing path on the BDD
        $validated['image']=$filename;
        // $produit = Produit::create($validated);

        Produit::create($validated);

        return redirect('catalogue');
    }

    public function changementProduit(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|max:50',
            'prix' => 'required',
            'description' => 'required',
            'catégorie' => 'required|max:30',
            'stock' => 'required'
        ]);

        $produit=Produit::find($request['produit_id']);
        $produit->nom=$validated['nom'];
        $produit->prix=$validated['prix'];
        $produit->description=$validated['description'];
        $produit->catégorie=$validated['catégorie'];
        $produit->stock=$validated['stock'];
        $produit->prix=$validated['prix'];       
        $produit->save();

        return view('fiche_produit',[
            'produit' => Produit::find($request['produit_id'])
        ]);
    }
}
