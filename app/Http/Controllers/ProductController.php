<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Pro_menu;
use App\File;
use DB;
use App\Variations;

use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Product::
        join('pro_menus','pro_menus.id','products.menu_id')
        ->join('pro_cats','pro_cats.id','products.cat_id')
        ->join('files','files.id','products.image')
        ->select('products.id', 'products.name as product_name', 'pro_menus.name as menu_name', 'pro_cats.name as cats_name','files.path' )
        ->get();
        // dd($data);
        return view('backend.product.index')->with('products',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // echo "HI";exit;
        //   $brand=Brand::get();
         $parent_menus=Pro_menu::select('name','id')->orderBy('name','ASC')->get();
        
         $get_categories = Category::select('name','id')->orderBy('name','ASC')->get();
        
        return view('backend.product.create')->with('parent_menus',$parent_menus)
        ->with('get_categories',$get_categories);
    }

    public function productsOptions(Request $request, $id)
    {
          $id = $id;
         $options=Variations::where('product_id',$id)->get();
        //  dd($options);
        return view('backend.product.option_index')->with('options',$options)->with('id',$id);
    }

    public function createOption(Request $request)
    {
        //   $id = $id;
        //  $options=Variations::where('product_id',$id)->get();
        //  dd($options);
        return view('backend.product.option');
    }


    public function StoreOptions(Request $request)
    {
    //  echo "hi";exit;
       
        $product_id = $request->input('product_id');
        // dd( $product_id);
        
        $pro_id = explode('/create-option/' ,$product_id);
        
        // print_r($pro_id[1]);exit;
        $addVariations = new Variations();
        $addVariations->name = $request->input('name');;
        $addVariations->price = $request->input('price');
        $addVariations->product_id  = $pro_id[1];
     
        $addVariations->save();

        if($addVariations){
            request()->session()->flash('success','Product option  updated');
        }
        else{
            request()->session()->flash('error','Please try again!!');
        }
        return redirect()->route('product.index');
     
    }

    public function editOption(Request $request, $id)
    {
        //   $id = $id;
         $options=Variations::where('id',$id)->get();
         foreach($options as $option){
         return view('backend.product.option_update')->with('option',$option);
         }
        
    }

    public function updateOption(Request $request, $id)
    {
    
        $addVariations = Variations::find($id);
        $addVariations->name = $request->input('name');
        $addVariations->price = $request->input('price');
        $addVariations->save();

        if($addVariations){
            request()->session()->flash('success','Product option  updated');
        }
        else{
            request()->session()->flash('error','Please try again!!');
        }
        return redirect()->route('product.index');
      

    }

    public function deleteOption(Request $request)
    {
        // dd('here');
        $variation=Variations::findOrFail($request->id);
        $status=$variation->delete();
       
        if($status){
            request()->session()->flash('success','Product successfully deleted');
        }
        else{
            request()->session()->flash('error','Error while deleting product');
        }
        return redirect()->route('product.index');
    }
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // dd($request);
        $this->validate($request,[
            'name'=>'string|required',
           
        ]);
        $addFile = new File; 
        if($request->has('image'))
       {
        $file= request('image');
        $filepath=$file->move(public_path().'/products',$file->getClientOriginalName());  
        $pathss = $file->getClientOriginalName();
        $path =   'products/'.$pathss;  
        // $realpath = explode('C:\xampp\htdocs\foodapp\public' , $filepath);
        $addFile->path= $path; 
        $addFile->save(); 
       }
       else{
        $addFile->path = 'no image';
        $addFile->save();
       }
        


        $addProducts = new Product();
        $addProducts->name = $request->input('name');;
        $addProducts->detail = $request->input('detail');
        $addProducts->price = $request->input('price');
        $addProducts->cat_id = $request->input('cat_id');
        $addProducts->menu_id  = $request->input('menu_id');
        $addProducts->image   = $addFile->id;
        $addProducts->weekend   = $request->input('weekend');
        $addProducts->weekday   = $request->input('weekday');
        $addProducts->promo   = $request->input('promo');
        $addProducts->promo_desc   = $request->input('promo_desc');
        $addProducts->save();
       
       
       
        if($addProducts){
            request()->session()->flash('success','Product Successfully added');
        }
        else{
            request()->session()->flash('error','Please try again!!');
        }
        return redirect()->route('product.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {
        
        $product=Product::findOrFail($id);
     
        $file=File::where('id',$product->image)->get();
        
        $categories=Category::get();

        $parent_menus=Pro_menu::get();
      
        return view('backend.product.edit')->with('product',$product)
                    ->with('file',$file)
                    ->with('categories',$categories)
                    ->with('parent_menus',$parent_menus);
                
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      
        $this->validate($request,[
            'name'=>'string|required',
        ]);
        //   dd($request->input('promo'));
        $product=Product::findOrFail($id);
        // dd($request);
        $product->name = $request->input('name');;
        $product->detail = $request->input('detail');
        $product->price = $request->input('price');
        $product->cat_id = $request->input('cat_id');
        $product->menu_id  = $request->input('menu_id');
        $product->weekend   = $request->input('weekend');
        $product->weekday   = $request->input('weekday');
        $product->promo   = $request->input('promo');
        $product->promo_desc   = $request->input('promo_desc');
        $product->save();
         
        $file = File::find($product->image);
        // dd($file);
        if($request->has('image'))
        {
         $files= request('image');
         $filepath=$files->move(public_path().'/products',$files->getClientOriginalName());  
         $pathss = $files->getClientOriginalName();
         $path =   'products/'.$pathss; 
         $file->path= $path;
         $file->save();  
        }
       else{
           $file->path = $file->path;
           $file->save();
       }

      
        request()->session()->flash('success','Product updated successfully');
    
   
        return redirect()->route('product.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // dd($id);
        $product=Product::findOrFail($id);
        $status=$product->delete();
        $file = File::find($product->image);
         $file->delete();
        
        if($status){
            request()->session()->flash('success','Product successfully deleted');
        }
        else{
            request()->session()->flash('error','Error while deleting product');
        }
        return redirect()->route('product.index');
    }
}
