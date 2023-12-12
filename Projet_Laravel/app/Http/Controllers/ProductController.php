<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function catalog()
    {
        $products=Product::all();

        return view('catalog',[
            'products' => $products
        ]);
    }

    public function productSheet($id)
    {
        return view('productSheet',[
            'product' => Product::find($id)
        ]);
    }

    public function adminNewProduct()

    {
        return view('adminNewProduct');
    }

    public function addProduct(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:50',
            'price' => 'required',
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
        // $product = product::create($validated);

        Product::create($validated);

        return redirect('catalog');
    }

    public function changeProduct(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:50',
            'price' => 'required',
            'description' => 'required',
            'stock' => 'required'
        ]);
        $product=Product::find($request['product_id']);
        $product->name=$validated['name'];
        $product->description=$validated['description'];
        $product->stock=$validated['stock'];
        $product->price=$validated['price'];
        if ($request['image']){
            $image_path = public_path('disk_products/'.$product->image);
            if(file_exists($image_path)){
                unlink($image_path);
            }
            Storage::disk('disk_products')->delete($product->image);
            $filename=$request->file('image') ->getClientOriginalName() ;
            $filename=date("Y-m-dH:i:s") . $filename;
            //upload folder in a folder and adding dateTime for avoid name mismatch
            $request->file('image') -> storeAs('disk_products', $filename, [ 'disk' => 'disk_products']);
            //storing path on the BDD
            $product->image=$filename;
        }
        $product->save();

        return view('productSheet',[
            'product' => Product::find($request['product_id'])
        ]);
    }


    public function modificationProductSheet ($id){
        return view('modificationProductSheet',[
            'product' => Product::find($id)
        ]);
    }
}
