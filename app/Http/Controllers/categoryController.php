<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class categoryController extends Controller
{
   public function categoryPage(){
        return view('pages.dashboard.category-page');
   }
   public function categoryList(Request $request){
      $user_id = $request->header('id');
      return Category::where('user_id',$user_id)->get();
   }

   public function categoryCreate(Request $request){
      $user_id = $request->header('id');
      return Category::create([
         'name'=>$request->input('name'),
         'user_id'=>$user_id
      ]);
   }

   public function categoryDelete(Request $request){
      $category_id = $request->input('id');
      $user_id = $request->header('id');
      return Category::where('id',$category_id)->where('user_id',$user_id)->delete();
   }

   public function categoryByID(Request $request){
      $category_id = $request->input('id');
      $user_id = $request->header('id');
      return Category::where('id',$category_id)->where('user_id',$user_id)->first();
   }

   public function categoryUpdate(Request $request){
      $category_id = $request->input('id');
      $user_id = $request->header('id');
      return Category::where('id',$category_id)->where('user_id',$user_id)->update([
         'name'=>$request->input('name'),
      ]);
   }


}
