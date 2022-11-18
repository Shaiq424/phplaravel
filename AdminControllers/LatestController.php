<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Latest;
use Illuminate\Support\Facades\File;
use Yajra\Datatables\Datatables;


class LatestController extends Controller
{
     // Ajax Datatables Messages
     public function ajaxdata(Request $request)
     {
             $data = Latest::latest()->get();
             return Datatables::of($data)
                 ->addIndexColumn()
                 ->editColumn('action', function($row){
                     $actionBtn = '<div class="action_btns d-flex justify-content-center">  <a href="latest/edit/'.$row->id.'" class="edit btn btn-success btn-sm"><i class="fas fa-pencil-alt"></i></a> 
                     
                     <form action="latest/delete/' . $row->id . '" method="GET">
                     '.csrf_field().'
                     '.method_field("GET").'
                     <button type="submit" class="delete btn btn-danger btn-sm text-white" onclick="return confirm(\'Are you sure you want to Delete ?\')"
                         ><i class="fas fa-trash" aria-hidden="true"></i>
                         </button>
                     </form> </div>';
 
                     return $actionBtn;
                 })
                 ->rawColumns(['action'])
                 ->make(true);
     }
     /**
      * Display a listing of the resource.
      *
      * @return \Illuminate\Http\Response
      */
     public function index()
     {   
         $latest = Latest::all();
         return view('admin.latest.index', compact('latest'));
     }
 
     /**
      * Show the form for creating a new resource.
      *
      * @return \Illuminate\Http\Response
      */
     public function add()
     {
         return view('admin.latest.add');
     }
 
     /**
      * Store a newly created resource in storage.
      *
      * @param  \Illuminate\Http\Request  $request
      * @return \Illuminate\Http\Response
      */
     public function store(Request $request)
     {
         $request->validate([
 
             'description' => 'required',
 
         ]);
 
         $latest = new Latest;
         $latest->description = $request->input('description');
         $latest->save();
         return redirect()->back()->with('message', 'Latest Update successfully Added'); 
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
         $latest = Latest::find($id);
          return view('admin.latest.edit', compact('latest'));
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
         $request->validate([
 
             'description' => 'required',
 
         ]);
 
         $latest = Latest::find($id);
         $latest->description = $request->input('description');
         $latest->save();
         return redirect()->back()->with('message', 'Latest Update successfully Updated');
     }
 
     /**
      * Remove the specified resource from storage.
      *
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
     public function delete($id)
     {
         $latest = Latest::find($id);
         $latest->delete($id);
         return redirect()->back()->with('message', 'Latest Update successfully Deleted');
     }
}
