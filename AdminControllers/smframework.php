<?php

namespace App\Http\Controllers\Admincontrollers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SocialManagementFramework;
use App\Models\Headings;

use Illuminate\Support\Facades\File;
use Yajra\Datatables\Datatables;



class smframework extends Controller
{
    // Ajax Datatables Messages
    public function ajaxdata(Request $request)
    {
            $data = SocialManagementFramework::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('action', function($row){
                    $actionBtn = '<div class="action_btns d-flex justify-content-center">  <a href="smframework/edit/'.$row->id.'" class="edit btn btn-success btn-sm"><i class="fas fa-pencil-alt"></i></a> 
                    
                    <form action="smframework/delete/' . $row->id . '" method="GET">
                    '.csrf_field().'
                    '.method_field("GET").'
                    <button type="submit" class="delete btn btn-danger btn-sm text-white" onclick="return confirm(\'Are you sure you want to Delete ?\')"
                        ><i class="fas fa-trash" aria-hidden="true"></i>
                        </button>
                    </form> </div>';

                    return $actionBtn;
                })
                ->editColumn('created_at', function ($row) {
                    return date('d-m-Y', strtotime($row->created_at));
                })
                ->editColumn('image', function($row){
                    $url=asset("uploads/SmFramework/$row->image");
                    $image = '<img src='.$url.' width="100px">' ;
                     return $image;
                })
                ->editColumn('lang_id', function($row){
                    $en = '<span class="bg-success text-white p-2" style="display: inline-block; font-size: .875rem;">English</span>';
                    $ur = '<span class="bg-info text-white p-2" style="display: inline-block; font-size: .875rem;">Urdu</span>';
                    $si = '<span class="bg-warning p-2" style="display: inline-block; font-size: .875rem; color: #fff !important;">Sindhi</span>';
                    
                    $lang_id = [1 => $en, 2 => $ur, 3 => $si];
                    return $lang_id[$row->lang_id];
                })
                ->editColumn('status', function($row){
                    $active = '<form action="/admin/smframework_status/' . $row->id . '" method="POST">
                    '.csrf_field().'
                    '.method_field("POST").'
                   <button class="btn btn-success text-white p-2 btn-sm" onclick="return confirm(\'Are you sure you want to update Status ?\')"
                        style="padding: 7px !important;font-size: .875rem;">Active
                        </button>
                    </form>';
                    $inactive = '<form action="/admin/smframework_status/' . $row->id . '" method="POST">
                    '.csrf_field().'
                    '.method_field("POST").'
                     <button class="btn btn-danger text-white p-2 btn-sm" onclick="return confirm(\'Are you sure you want to update Status ?\')"
                        style="padding: 7px !important;font-size: .875rem;">Inactive
                        </button>
                    </form>';
                    $status = [0 => $inactive, 1 => $active];
                    return $status[$row->status];
                })
                ->rawColumns(['action', 'lang_id', 'status', 'created_at', 'image'])
                ->make(true);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $smframework = SocialManagementFramework::all();
        return view('admin.Pages.SmFramework.index', compact('smframework'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        return view('admin.Pages.SmFramework.add');
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
            'image' => 'required',
            'download_pdf' => 'required',

        ]);

        $smframework = new SocialManagementFramework;
        $smframework->title = $request->input('title');
        $smframework->image = $request->input('image');
        $smframework->download_pdf = $request->input('download_pdf');
        $smframework->lang_id = $request->input('lang_id');
        $smframework->status = $request->input('status');
        if($request->hasfile('image')) 
        {
            $file = $request->file('image');
            $extention = $file->getClientOriginalExtension();
            $filename = time(). '.' .$extention;
            $file->move('uploads/SmFramework/', $filename);
            $smframework->image =$filename;
        }
        if($request->hasfile('download_pdf')) 
        {
            $file = $request->file('download_pdf');
            $extention = $file->getClientOriginalExtension();
            $filename = time(). '.' .$extention;
            $file->move('uploads/SmFramework/pdf', $filename);
            $smframework->download_pdf =$filename;
        }
        $smframework->status = $request->input('status') == true ? '1':'0';
        $smframework->save();
        return redirect()->back()->with('message', 'Social Management Framework successfully Added'); 
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
        $smframework = SocialManagementFramework::find($id);
         return view('admin.Pages.SmFramework.edit', compact('smframework'));
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

        ]);

        $smframework = SocialManagementFramework::find($id);
        $smframework->title = $request->input('title');
        $smframework->lang_id = $request->input('lang_id');
        $smframework->status = $request->input('status');
        if($request->hasfile('image')) 
        {
            $destination = 'uploads/SmFramework/' .$smframework->image;
            if(File::exists($destination)){
                File::delete($destination);
            }

            $file = $request->file('image');
            $extention = $file->getClientOriginalExtension();
            $filename = time(). '.' .$extention;
            $file->move('uploads/SmFramework/', $filename);
            $smframework->image =$filename;
        }
        if($request->hasfile('download_pdf')) 
        {
            $destination = 'uploads/SmFramework/' .$smframework->download_pdf;
            if(File::exists($destination)){
                File::delete($destination);
            }

            $file = $request->file('download_pdf');
            $extention = $file->getClientOriginalExtension();
            $filename = time(). '.' .$extention;
            $file->move('uploads/SmFramework/pdf', $filename);
            $smframework->download_pdf =$filename;
        }
        $smframework->status = $request->input('status') == true ? '1':'0';
        $smframework->save();
        return redirect()->back()->with('message', 'Social Management Framework successfully Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $smframework = SocialManagementFramework::find($id);
        $smframework->delete($id);
        return redirect()->back()->with('message', 'Social Management Framework successfully Deleted');
    }

    public function statusUpdate($id)
    {   
        $data =  SocialManagementFramework::where('id' , $id )->get('status'); 
        $area = json_decode($data, true);
        if($area[0]['status'] == 0)
        {
        $affected = SocialManagementFramework::where('id', $id)
                ->update(array('status' => 1));
                return redirect()->back()->with('message', 'Status Updated Successfully');
        }
        else
        {
            $affected = SocialManagementFramework::where('id', $id)
                ->update(array('status' => 0));
                return redirect()->back()->with('message', 'Status Updated Successfully');
        }
    }
}
