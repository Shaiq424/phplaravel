<?php

namespace App\Http\Controllers\Admincontrollers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Click;
use Illuminate\Support\Facades\File;
use Yajra\Datatables\Datatables;


class ClickController extends Controller
{
    public function ajaxdata(Request $request)
    {
            $data = Click::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('action', function($row){
                    $actionBtn = '<div class="action_btns d-flex justify-content-center">  <a href="click/edit/'.$row->id.'" class="edit btn btn-success btn-sm"><i class="fas fa-pencil-alt"></i></a> 
                    
                    <form action="click/delete/' . $row->id . '" method="GET">
                    '.csrf_field().'
                    '.method_field("GET").'
                    <button type="submit" class="delete btn btn-danger btn-sm text-white" onclick="return confirm(\'Are you sure you want to Delete ?\')"
                        ><i class="fas fa-trash" aria-hidden="true"></i>
                        </button>
                    </form> </div>';

                    return $actionBtn;
                })
                ->editColumn('image', function($row){
                    $url=asset("uploads/click/$row->image");
                    $image = '<img src='.$url.' width="100px">' ;
                     return $image;
                })
                ->rawColumns(['action', 'image'])
                ->make(true);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $click = Click::all();
        return view('admin.click.index', compact('click'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        return view('admin.click.add');
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

            'title' => 'required',
            'description' => 'required',
            'category' => 'required',
            'image' => 'required',
            'file' => 'required',

        ]);

        $click = new Click;
        $click->title = $request->input('title');
        $click->description = $request->input('description');
        $click->category = $request->input('category');
        $click->image = $request->input('image');
        $click->file = $request->input('file');
        if($request->hasfile('image')) 
        {
            $file = $request->file('image');
            $extention = $file->getClientOriginalExtension();
            $filename = time(). '.' .$extention;
            $file->move('uploads/click/', $filename);
            $click->image =$filename;
        }
        if($request->hasfile('file')) 
        {
            $file = $request->file('file');
            $extention = $file->getClientOriginalExtension();
            $filename = time(). '.' .$extention;
            $file->move('uploads/click/pdf', $filename);
            $click->file =$filename;
        }
        $click->save();
        return redirect()->back()->with('message', 'Click successfully Added'); 
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
        $click = Click::find($id);
         return view('admin.click.edit', compact('click'));
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

            'title' => 'required',
            'category' => 'required',
            'description' => 'required',

        ]);

        $click = Click::find($id);
        $click->title = $request->input('title');
        $click->category = $request->input('category');
        $click->description = $request->input('description');
        if($request->hasfile('image')) 
        {
            $destination = 'uploads/click/' .$click->image;
            if(File::exists($destination)){
                File::delete($destination);
            }

            $file = $request->file('image');
            $extention = $file->getClientOriginalExtension();
            $filename = time(). '.' .$extention;
            $file->move('uploads/click/', $filename);
            $click->image =$filename;
        }
        if($request->hasfile('file')) 
        {
            $destination = 'uploads/click/' .$click->file;
            if(File::exists($destination)){
                File::delete($destination);
            }

            $file = $request->file('file');
            $extention = $file->getClientOriginalExtension();
            $filename = time(). '.' .$extention;
            $file->move('uploads/click/pdf', $filename);
            $click->file =$filename;
        }
        $click->save();
        return redirect()->back()->with('message', 'Click successfully Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $click = Click::find($id);
        $click->delete($id);
        return redirect()->back()->with('message', 'Click successfully Deleted');
    }

    public function statusUpdate($id)
    {   
        $data =  Click::where('id' , $id )->get('status'); 
        $area = json_decode($data, true);
        if($area[0]['status'] == 0)
        {
        $affected = Click::where('id', $id)
                ->update(array('status' => 1));
                return redirect()->back()->with('message', 'Status Updated Successfully');
        }
        else
        {
            $affected = Click::where('id', $id)
                ->update(array('status' => 0));
                return redirect()->back()->with('message', 'Status Updated Successfully');
        }
    }
}
