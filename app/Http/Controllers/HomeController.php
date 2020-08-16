<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class HomeController extends Controller
{
  
   private $product;
    public function __construct(Product $product)
    {
        $this->product = $product; 
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     passamos a mossa home primcipal para ca
     */
    public function index()
    {

       $products =  $this->product->limit(6)->orderBy('id', 'DESC')->get();
       $stores = \App\Store::limit(3)->orderBy('id', 'DESC')->get();

      // $categories = \App\Category::all(['name', 'slug']);
     // , 'categories'
      

        return view('welcome', compact('products', 'stores'));
      
}

public function single($slug)
    {

      $product =  $this->product->whereSlug($slug)->first();
          return view('single', compact('product'));
      
}

}