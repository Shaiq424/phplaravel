<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PressRelease;
use Illuminate\Support\Facades\File;
use Yajra\Datatables\Datatables;

class PressController extends Controller
{
    public function ajaxdata(Request $request)
    {
            $data = PressRelease::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('action', function($row){
                    $actionBtn = '<div class="action_btns d-flex justify-content-center">  <a href="press/edit/'.$row->id.'" class="edit btn btn-success btn-sm"><i class="fas fa-pencil-alt"></i></a> 
                    
                    <form action="press/delete/' . $row->id . '" method="GET">
                    '.csrf_field().'
                    '.method_field("GET").'
                    <button type="submit" class="delete btn btn-danger btn-sm text-white" onpress="return confirm(\'Are you sure you want to Delete ?\')"
                        ><i class="fas fa-trash" aria-hidden="true"></i>
                        </button>
                    </form> </div>';

                    return $actionBtn;
                })
                ->editColumn('image', function($row){
                    $url=asset("uploads/press/$row->image");
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
        $press = PressRelease::all();
        return view('admin.press.index', compact('press'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        return view('admin.press.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $press = new PressRelease;
        $press->description = $request->input('description');
        $press->image = $request->input('image');
        if($request->hasfile('image')) 
        {
            $file = $request->file('image');
            $extention = $file->getClientOriginalExtension();
            $filename = time(). '.' .$extention;
            $file->move('uploads/press/', $filename);
            $press->image =$filename;
        }
        $press->save();
        return redirect()->back()->with('message', 'press successfully Added'); 
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
        $press = PressRelease::find($id);
         return view('admin.press.edit', compact('press'));
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

        $press = PressRelease::find($id);
        $press->description = $request->input('description');
        if($request->hasfile('image')) 
        {
            $destination = 'uploads/press/' .$press->image;
            if(File::exists($destination)){
                File::delete($destination);
            }

            $file = $request->file('image');
            $extention = $file->getClientOriginalExtension();
            $filename = time(). '.' .$extention;
            $file->move('uploads/press/', $filename);
            $press->image =$filename;
        }
        $press->save();
        return redirect()->back()->with('message', 'press successfully Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $press = PressRelease::find($id);
        $press->delete($id);
        return redirect()->back()->with('message', 'press successfully Deleted');
    }
}
