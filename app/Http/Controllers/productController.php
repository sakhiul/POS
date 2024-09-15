<?php

namespace App\Http\Controllers;

use App\Models\Product;
use File;
use Illuminate\Http\Request;

class productController extends Controller
{
    public function productPage(){
        return view('pages.dashboard.product-page');
   }
   

   public function productCreate(Request $request){
      $user_id = $request->header('id');


      //prepare file name & path
      $img = $request->file('img');
      $t = time();
      $file_name = $img->getClientOriginalName();
      $img_name = "{$user_id}-{$t}-{$file_name}";
      $img_url = "uploads/{$img_name}";

      //upload file
      $img->move(public_path('uploads'),$img_name);

      return Product::create([
         'name'=>$request->input('name'),
         'price'=>$request->input('price'),
         'unit'=>$request->input('unit'),
         'img_url' => $img_url,
         'category_id' => $request->input('category_id'),
         'user_id'=>$user_id
      ]);
   }

   public function productList(Request $request){
      $user_id = $request->header('id');
      return Product::where('user_id',$user_id)->get();
   }

   public function productDelete(Request $request){
      $user_id = $request->header('id');
      $product_id = $request->input('id');
      $filePath = $request->input('file_path');
      File::delete('$filePath');
      return Product::where('id',$product_id)->where('user_id',$user_id)->delete();
   }

   public function productByID(Request $request){
      $user_id = $request->header('id');
      $product_id = $request->input('id');
      return Product::where('id',$product_id)->where('user_id',$user_id)->first();
   }

   public function productUpdate(Request $request){
      $user_id = $request->header('id');
      $product_id = $request->input('id');

      if($request->hasFile('img')){

         //upload new file
      $img = $request->file('img');
      $t = time();
      $file_name = $img->getClientOriginalName();
      $img_name = "{$user_id}-{$t}-{$file_name}";
      $img_url = "uploads/{$img_name}";

      $img->move(public_path('uploads'),$img_name);

      //delete old file 
      $filePath = $request->input('file_path');
      File::delete($filePath);

         //update product
         return Product::where('id',$product_id)->where('user_id',$user_id)->update([
         'name'=>$request->input('name'),
         'price'=>$request->input('price'),
         'unit'=>$request->input('unit'),
         'img_url' => $img_url,
         'category_id' => $request->input('category_id'),
         ]);


      }
      else{
         return Product::where('id',$product_id)->where('user_id',$user_id)->update([
            'name'=>$request->input('name'),
            'price'=>$request->input('price'),
            'unit'=>$request->input('unit'),
            'category_id' => $request->input('category_id')
         ]);
      }
    }
}
