<?php

namespace App\Http\Controllers;

use App\Models\product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class productController extends Controller
{
    public function index(){
        return view('index');
    }
    // handle insert product ajax request
    public function store(Request $request){
      $file = $request->file('avatar');
      $fileName = time() . '.' . $file->getClientOriginalExtension();
      $file->storeAs('public/images',$fileName);

      $prdData =[
          'product_name' => $request->Pname,
          'category'=>$request->Ctg,
          'vendor'=>$request->Vendor,
          'amount'=>$request->Amount,
           'avatar'=>$fileName,
           
      ];
    product::create($prdData);
      return response()->json([
          'status'=>200
      ]);
    }
    // handle fetch all products ajax request
    public function fetchAll(){
      $prds = product::all();
      $output = '';
      if($prds->count()>0){
        $output .= '<table class = "table table-striped table-sm text-center
        align-middle ">
        <thead>
        <tr>
        <th>ID</th>
        <th>Avatar</th>
        <th>Product_Name</th>
        <th>Category</th>
        <th>Vendor</th>
        <th>Amount</th>
        <th>Action</th>
        </tr>
        </thead>
        <tbody>';
        foreach($prds as $prd){
          $output .= '<tr>
          <td>'.$prd->id.'</td>
          <td><img src = "storage/images/'.$prd->avatar.'" width="50"
          class="img-thumbnail rounded-circle"></td>
          <td>'.$prd->product_name.'</td>
          <td>'.$prd->category.'</td>
          <td>'.$prd->vendor.'</td>
          <td>'.$prd->amount.'</td>
          <td>
          <a href="#" id="' . $prd->id .'" class="text-success mx-1
          editIcon" data-bs-toggle="modal" data-bs-target="#editProductModal"
          ><i class="bi-pencil-square h4"></i></a>
    
          <a href="#" id="' . $prd->id .'" class="text-danger mx-1
          deleteIcon"><i class="bi-trash h4"></i></a>
          </td>

          </tr>';
        }
        $output .= '</tbody></table>';
        echo $output;

      } else{
        echo'<h1 class="text-center text-secondary my-5">
        No product present in the database</h1>';
      }
    }
    //handle edit product ajax request
    public function edit(Request $request){
      $id = $request->id;
      $prd=product::find($id);
      return response()->json($prd);
    }
    //handle update product ajax request
    public function update(Request $request){
      $fileName='';
       $prd = product::find($request->prd_id);
       if($request->hasFile('avatar')){
         $file=$request->file('avatar');
         $fileName= time() . '.' . $file->getClientOriginalExtension();
         $file->storeAs('public/images', $fileName);
         if($prd->avatar){
           Storage::delete('public/images/' . $prd->avatar);
         }
        } else{
           $fileName  = $request->prd_avatar;
         }
         $prdData =[
           'product_name' => $request->Pname,
           'category'=>$request->Ctg,
           'vendor'=>$request->Vendor,
           'amount'=>$request->Amount,
            'avatar'=>$fileName,
         ];
         $prd->update($prdData);
         return response()->json([
            'status'=>200
         ]);
       
        }
        //handle delete product ajax request
        public function delete(Request $request){
          $id = $request->id;
          $prd = product::find($id);
          if(Storage::delete('public/images/' .$prd->avatar)){
            product::destroy($id);
          }
        }
}
