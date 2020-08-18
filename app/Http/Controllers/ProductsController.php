<?php

namespace App\Http\Controllers;

use App\Model\Product;

class ProductsController extends Controller
{
	public function index()
	{
        return view('products.index');
	}

	public function getProducts()
	{
		$search = request()->search;

        if($search == ''){
            $products = Product::orderby('nom','asc')->select('id','nom')->limit(5)->get();
         }else{
            $products = Product::orderby('nom','asc')->select('id','nom')->where('nom', 'like', '%' .$search . '%')->limit(5)->get();
         }

         $response = array();
         foreach($products as $product){
            $response[] = array(
                 "id"=>$product->id,
                 "text"=>$product->nom
            );
         }

         echo json_encode($response);
         exit;
        return 0;
   }
   
   public function getProduct(){
      return Product::findOrFail(request('product_id'));
   }
}
