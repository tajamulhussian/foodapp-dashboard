<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;
use App\Pro_menu;
use App\File;
use DB;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category=Category::paginate(10);
        //  dd($category);
        return view('backend.category.index')->with('categories',$category);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $parent_cats=Category::select('name')->orderBy('name','ASC')->get();
        // dd($parent_menu);
        return view('backend.category.create')->with('parent_menus',$parent_cats);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->all();
        $this->validate($request,[
            'name'=>'string|required',
           
        ]);

    //     $addFile = new File; 
    //     if($request->has('image'))
    //    {
    //     $file= request('image');
    //     $filepath=$file->move(public_path().'/products',$file->getClientOriginalName()); 
    //     $pathss = $file->getClientOriginalName(); 
    //     $path = 'products/'.$pathss;
    //     // $realpath = explode('C:\xampp\htdocs\foodapp\public' , $filepath);
    //     $addFile->path= $path; 
    //     $addFile->save(); 
    //    }
    //    else{
    //     $addFile->path= 'no image'; 
    //     $addFile->save(); 
    //    }
        

        $addcategory = new Category();
        // $addcategory->banner = $addFile->id;
        $addcategory->name = $request->input('name');
        $addcategory->save();
        
       
        if($addcategory){
            request()->session()->flash('success','Category successfully added');
        }
        else{
            request()->session()->flash('error','Error occurred, Please try again!');
        }
        return redirect()->route('category.index');


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
    public function edit($id)
    { 
       
        // $datas = File:: join('pro_cats','pro_cats.banner','files.id')
        // ->where('files.id',$id)->get();
        $datas = Category::get();
        foreach($datas as $data){
            return view('backend.category.edit')->with('category',$data);
        }
       
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
        // dd($request->banner_id);
        $category=Category::findOrFail($id);
        $this->validate($request,[
            'name'=>'string|required',
        ]);
        $category->name = request('name');   
        $category->save();
         
    //     $file = File::find($request->banner_id);
    //     // dd($file);
    //     if($request->has('image'))
    //     {
    //      $files= request('image');
    //      $filepath=$files->move(public_path().'/products',$files->getClientOriginalName()); 
    //      $pathss = $files->getClientOriginalName(); 
    //      $path = 'products/'.$pathss;
    //      // $realpath = explode('C:\xampp\htdocs\foodapp\public' , $filepath);
    //      $file->path= $path;
    //      $file->save();  
    //     }
    //    else{
    //        $file->path = $file->path;
    //        $file->save();
    //    }

       
        return redirect()->route('category.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category=Category::findOrFail($id);
        // dd($category);
        $category->delete();
        // print_r($id);
        // $file=File::find($id);
        // $file->delete();
        // DB::table("pro_cats")->where("banner", $file->id)->delete();
      
        // print_r($category);
        
        

       
    }

    public function getChildByParent(Request $request){
        // return $request->all();
        $category=Category::findOrFail($request->id);
        $child_cat=Category::getChildByParentID($request->id);
        // return $child_cat;
        if(count($child_cat)<=0){
            return response()->json(['status'=>false,'msg'=>'','data'=>null]);
        }
        else{
            return response()->json(['status'=>true,'msg'=>'','data'=>$child_cat]);
        }
    }
}
