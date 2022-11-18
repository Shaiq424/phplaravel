<?php

namespace App\Http\Controllers\Admincontrollers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Laws;
use App\Models\Headings;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\File;

class laws_acts extends Controller
{
    // Ajax Datatables Local councils
    public function ajaxdata(Request $request)
    {
            $data = Laws::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('action', function($row){
                    $actionBtn = '<div class="action_btns d-flex justify-content-center"> <a href="laws/edit/'.$row->id.'" class="edit btn btn-success btn-sm"><i class="fas fa-pencil-alt"></i></a> 
                    
                    <form action="laws/delete/' . $row->id . '" method="GET">
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
                ->editColumn('updated_at', function ($row) {
                    return date('d-m-Y', strtotime($row->updated_at));
                })
                ->editColumn('lang_id', function($row){
                    $en = '<span class="bg-success text-white p-2" style="display: inline-block; font-size: .875rem;">English</span>';
                    $ur = '<span class="bg-info text-white p-2" style="display: inline-block; font-size: .875rem;">Urdu</span>';
                    $si = '<span class="bg-warning p-2" style="display: inline-block; font-size: .875rem; color: #fff !important; ">Sindhi</span>';
                    
                    $lang_id = [1 => $en, 2 => $ur, 3 => $si];
                    return $lang_id[$row->lang_id];
                })
                ->editColumn('status', function($row){
                    $active = '<form action="/admin/laws_status/' . $row->id . '" method="POST">
                    '.csrf_field().'
                    '.method_field("POST").'
                   <button class="btn btn-success text-white p-2 btn-sm" onclick="return confirm(\'Are you sure you want to update Status ?\')"
                        style="padding: 7px !important;font-size: .875rem;">Active
                        </button>
                    </form>';
                    $inactive = '<form action="/admin/laws_status/' . $row->id . '" method="POST">
                    '.csrf_field().'
                    '.method_field("POST").'
                     <button class="btn btn-danger text-white p-2 btn-sm" onclick="return confirm(\'Are you sure you want to update Status ?\')"
                        style="padding: 7px !important;font-size: .875rem;">Inactive
                        </button>
                    </form>';
                    $status = [0 => $inactive, 1 => $active];
                    return $status[$row->status];
                })
                ->rawColumns(['action', 'lang_id', 'status', 'created_at', 'updated_at'])
                ->make(true);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $laws = Laws::all();
        return view('admin.Pages.Laws.index', compact('laws'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        return view('admin.Pages.Laws.add');
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
            'category' => 'required',
            'download_pdf' => 'required',
        ]);
        
        $laws = new Laws;
        $laws->description = $request->input('description');
        $laws->category = $request->input('category');
        $laws->download_pdf = $request->input('download_pdf');
        $laws->lang_id = $request->input('lang_id');
        $laws->status = $request->input('status');
        if($request->hasfile('download_pdf')) 
        {
            $file = $request->file('download_pdf');
            $extention = $file->getClientOriginalExtension();
            $filename = time(). '.' .$extention;
            $file->move('uploads/laws_Pdfs/', $filename);
            $laws->download_pdf =$filename;
        }
        $laws->status = $request->input('status') == true ? '1':'0';
        $laws->save();
        return redirect()->back()->with('message', 'Laws successfully Added');
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
        $laws = Laws::find($id);
         return view('admin.Pages.Laws.edit', compact('laws'));
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
            'category' => 'required',
        ]);

        $laws = Laws::find($id);
        $laws->description = $request->input('description');
        $laws->category = $request->input('category');
        $laws->lang_id = $request->input('lang_id');
        $laws->status = $request->input('status');
        if($request->hasfile('download_pdf')) 
        {
            $destination = 'uploads/laws_Pdfs/' .$laws->download_pdf;
            if(File::exists($destination)){
                File::delete($destination);
            }

            $file = $request->file('download_pdf');
            $extention = $file->getClientOriginalExtension();
            $filename = time(). '.' .$extention;
            $file->move('uploads/laws_Pdfs/', $filename);
            $laws->download_pdf =$filename;
        }
        $laws->status = $request->input('status') == true ? '1':'0';
        $laws->save();
        return redirect()->back()->with('message', 'Laws successfully Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $laws = Laws::find($id);
        $laws->delete($id);
        return redirect()->back()->with('message', 'Laws successfully Deleted');
    }

    public function statusUpdate($id)
    {   
        $data =  Laws::where('id' , $id )->get('status'); 
        $area = json_decode($data, true);
        if($area[0]['status'] == 0)
        {
        $affected = Laws::where('id', $id)
                ->update(array('status' => 1));
                return redirect()->back()->with('message', 'Status Updated Successfully');
        }
        else
        {
            $affected = Laws::where('id', $id)
                ->update(array('status' => 0));
                return redirect()->back()->with('message', 'Status Updated Successfully');
        }
    }
}
