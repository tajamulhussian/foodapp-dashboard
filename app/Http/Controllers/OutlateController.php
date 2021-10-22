<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Outlate;
use App\File;
class OutlateController extends Controller
{
    public function index(){
        $data = File::join('outlates','outlates.banner','files.id')->paginate(10);
    //    dd($data);
         return view('backend.outlate.index')->with('outlates',$data);
     }
 
     public function create(){
         
         // $parent_cats=Category::where('is_parent',1)->orderBy('title','ASC')->get();
         return view('backend.outlate.create');
     }
 
     public function store(Request $request ){

       
         // $location = $request->input('latitude').','.$request->input('longitude');
        //  dd($request);
         $addFile = new File; 
         if($request->has('image'))
        {
         $file=  request('image');
         $filepath=$file->move(public_path().'\products',$file->getClientOriginalName());  
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
        
 
         $addOutlates = new Outlate();
         $addOutlates->banner = $addFile->id;
         $addOutlates->name = $request->input('name');
         $addOutlates->address = $request->input('address');
         $addOutlates->description = $request->input('description');
         // $addOutlates->location = $location;
         $addOutlates->latitude = $request->input('latitude');
         $addOutlates->longitude = $request->input('longitude');
         $addOutlates->phone = $request->input('phone');
         $addOutlates->start = $request->input('start');
         $addOutlates->end = $request->input('end');
         $addOutlates->save();
 
         return redirect('admin/outlate');
     }

     public function edit($id)
    { 
       
        $datas = File::join('outlates','outlates.banner','files.id')->where('outlates.id', $id)->get();
        // dd($datas);
        foreach($datas as $data){
            return view('backend.outlate.edit')->with('outlate',$data);
        }
       
    }

    public function update(Request $request, $id)
    {
        // $location = $request->input('latitude').','.$request->input('longitude');
        $Outlates=Outlate::findOrFail($id);
        $this->validate($request,[
            'name'=>'string|required',
        ]);
        $Outlates->name = $request->input('name');
        $Outlates->address = $request->input('address');
        $Outlates->description = $request->input('description');
        // $Outlates->location = $location;
        $Outlates->latitude = $request->input('latitude');
        $Outlates->longitude = $request->input('longitude');
        $Outlates->phone = $request->input('phone');
        $Outlates->start = $request->input('start');
        $Outlates->end = $request->input('end');
        $Outlates->save();

        $file = File::find($Outlates->banner);
        // dd($file);
        if($request->has('image'))
        {
         $files= request('image');
         $filepath=$files->move(public_path().'\products',$files->getClientOriginalName()); 
         $pathss = $file->getClientOriginalName(); 
         $path =   'products/'.$pathss; 
         // $realpath = explode('C:\xampp\htdocs\foodapp\public' , $filepath);
         $file->path= $path;
         $file->save();  
        }
       else{
           $file->path = $file->path;
           $file->save();
       }

       
        return redirect('admin/outlate');
    }

    public function delete(Request $request){
            // dd($id);
           $outlate = Outlate::find($request->id);
           $outlate->delete();
           $file = File::find($outlate->banner);
           $file->delete();
           
        }
 
}
