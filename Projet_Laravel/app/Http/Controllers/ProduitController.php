<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
        return view('admin_ajout_produit');
    }

    public function ajoutProduit(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|max:50',
            'prix' => 'required',
            'description' => 'required',
            'image' => 'required',
            'stock' => 'required'
        ]);
        $filename=$request->file('image') ->getClientOriginalName() ;
        $filename=date("Y-m-dH:i:s") . $filename;
        //upload folder in a folder and adding dateTime for avoid name mismatch
        $request->file('image') -> storeAs('disk_products', $filename, [ 'disk' => 'disk_products']);
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
            'stock' => 'required'
        ]);
        $produit=Produit::find($request['produit_id']);
        $produit->nom=$validated['nom'];
        $produit->prix=$validated['prix'];
        $produit->description=$validated['description'];
        $produit->stock=$validated['stock'];
        $produit->prix=$validated['prix'];
        if ($request['image']){
            $image_path = public_path('disk_products/'.$produit->image);
            if(file_exists($image_path)){
                unlink($image_path);
            }
            Storage::disk('disk_products')->delete($produit->image);
            $filename=$request->file('image') ->getClientOriginalName() ;
            $filename=date("Y-m-dH:i:s") . $filename;
            //upload folder in a folder and adding dateTime for avoid name mismatch
            $request->file('image') -> storeAs('disk_products', $filename, [ 'disk' => 'disk_products']);
            //storing path on the BDD
            $produit->image=$filename;
        }
        $produit->save();

        return view('fiche_produit',[
            'produit' => Produit::find($request['produit_id'])
        ]);
    }


    public function modificationFicheProduit($id){
        return view('admin_modification_fiche_produit',[
            'produit' => Produit::find($id)
        ]);
    }
}
