<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;
use App\Pro_menu;
use App\File;
use DB;



class MenuController extends Controller
{
    public function index(){
       $data = File::
       join('pro_menus','pro_menus.banner','files.id')->paginate(10);
       // dd($data);
      
        return view('backend.menu.index')->with('data',$data);
    }

    public function create(){
        
        // $parent_cats=Category::where('is_parent',1)->orderBy('title','ASC')->get();
        return view('backend.menu.create');
    }

    public function store(Request $request ){
        $addFile = new File; 
        if($request->has('image'))
       {
        $file=  request('image');
        $filepath=$file->move(public_path().'/products',$file->getClientOriginalName());  
        $pathss = $file->getClientOriginalName(); 
        $path =   'products/'.$pathss;
        // $realpath = explode('C:\xampp\htdocs\foodapp\public' , $filepath);
        // print_r($realpath);exit;
        $addFile->path= $path;  
        $addFile->save();
       }
       else{
        $addFile->path= 'no image';  
        $addFile->save();
       }
      

        $addmenu = new Pro_menu();
        $addmenu->banner = $addFile->id;
        $addmenu->name = $request->input('name');
        $addmenu->save();

        return redirect('admin/menu');
    }

    public function edit($id)
    { 
       
        $datas = File:: join('pro_menus','pro_menus.banner','files.id')
        ->where('pro_menus.id',$id)->get();
        // dd($datas);
        foreach($datas as $data){
            return view('backend.menu.edit')->with('menu',$data);
        }
       
    }

    public function update(Request $request, $id)
    {
        // dd('here');
        // dd($request->banner_id);
        $Pro_menu=Pro_menu::findOrFail($id);
        // dd($Pro_menu);
        $this->validate($request,[
            'name'=>'string|required',
        ]);
        $Pro_menu->name = request('name');   
        $Pro_menu->save();
         
        $file = File::find($Pro_menu->banner);
        // dd($file);
        if($request->has('image'))
        {
         $files= request('image');
         $filepath=$files->move(public_path().'/products',$files->getClientOriginalName());  
         $pathss = $files->getClientOriginalName();
         $path =   'products/'.$pathss; 
         // $realpath = explode('C:\xampp\htdocs\foodapp\public' , $filepath);
         $file->path= $path;
         $file->save();  
        }
       else{
           $file->path = $file->path;
           $file->save();
       }

       
        return redirect('admin/menu');
    }

    public function delete(Request $request){
    //    dd($request);
       $menu = Pro_menu::find($request->id);
       $menu->delete();
       $file = File::find($menu->banner);
       $file->delete();
    }
}
