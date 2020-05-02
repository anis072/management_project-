<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Filee;
use App\Reclamation;
use Illuminate\Http\Request;

class FileController extends Controller
{
    //
    public function files($id){
      $files= Filee::where('projet_id',$id)->get();
     return response()->json([
         'files'=>$files
         ]);
  }
  public function filest($id){
     return   Filee::where('task_id',$id)->latest()->paginate(100);
    //  return response()->json(['files'=>$files]);
  }
  public function complaintsfile($id){
    $files= Filee::where('rec_id',$id)->get();
    return response()->json([
        'files'=>$files
        ]);
  }
      public function formSubmit(Request $request,$id)
  {
      $this->validate($request,[
        'file' => 'required|mimes:doc,png,jpg,docx,pdf,txt|max:2048'
      ]);
      $extention= time().'.'.$request->file->getClientOriginalExtension();
      $fileName =$request->name.'.'.$extention;
      $request->file->move(public_path('upload'), $fileName);
      $filetable=new Filee;
      $filetable->file= $fileName;
      $filetable->projet_id=$id;
      $filetable->save();
      return response()->json(['success'=>'You have successfully upload file.']);
  }

  public function formSubmitt(Request $request,$id)
  {
      $this->validate($request,[
        'file' => 'required|mimes:doc,png,jpg,docx,pdf,txt|max:2048'

      ]) ;
      $extention= time().'.'.$request->file->getClientOriginalExtension();
      $fileName =$request->name.'.'.$extention;
      $request->file->move(public_path('upload'), $fileName);
      $filetable=new Filee;
      $filetable->file= $fileName;
      $filetable->task_id=$id;
      $filetable->save();
      return response()->json(['success'=>'You have successfully upload file.']);
  }
}
