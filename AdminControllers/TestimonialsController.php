<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Testimonials;
use Illuminate\Support\Facades\File;
use Yajra\Datatables\Datatables;


class TestimonialsController extends Controller
{
    // Ajax Datatables Messages
    public function ajaxdata(Request $request)
    {
            $data = Testimonials::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('action', function($row){
                    $actionBtn = '<div class="action_btns d-flex justify-content-center"><a href="testimonials/edit/'.$row->id.'" class="edit btn btn-success btn-sm"><i class="fas fa-pencil-alt"></i></a> 
                    
                    <form action="testimonials/delete/' . $row->id . '" method="GET">
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
                    $url=asset("uploads/testimonials/$row->image");
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
                    $active = '<form action="/admin/testimonials_status/' . $row->id . '" method="POST">
                    '.csrf_field().'
                    '.method_field("POST").'
                   <button class="btn btn-success text-white p-2 btn-sm" onclick="return confirm(\'Are you sure you want to update Status ?\')"
                        style="padding: 7px !important;font-size: .875rem; ">Active
                        </button>
                    </form>';
                    $inactive = '<form action="/admin/testimonials_status/' . $row->id . '" method="POST">
                    '.csrf_field().'
                    '.method_field("POST").'
                     <button class="btn btn-danger text-white p-2 btn-sm" onclick="return confirm(\'Are you sure you want to update Status ?\')"
                        style="padding: 7px !important;font-size: .875rem; ">Inactive
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
        $testimonials = Testimonials::all();
        return view('admin.Testimonials.index', compact('testimonials'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        return view('admin.Testimonials.add');
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

            'name' => 'required',
            'designation' => 'required',
            'message' => 'required',

        ]);

        $testimonials = new Testimonials;
        $testimonials->image = $request->input('image');
        $testimonials->name = $request->input('name');
        $testimonials->designation = $request->input('designation');
        $testimonials->message = $request->input('message');
        $testimonials->lang_id = $request->input('lang_id');
        $testimonials->status = $request->input('status');
        if($request->hasfile('image')) 
        {
            $file = $request->file('image');
            $extention = $file->getClientOriginalExtension();
            $filename = time(). '.' .$extention;
            $file->move('uploads/testimonials/', $filename);
            $testimonials->image =$filename;
        }
        $testimonials->status = $request->input('status') == true ? '1':'0';
        $testimonials->save();
        return redirect()->back()->with('message', 'Testimonials successfully Added'); 
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
        $testimonials = Testimonials::find($id);
         return view('admin.Testimonials.edit', compact('testimonials'));
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

            'name' => 'required',
            'designation' => 'required',
            'message' => 'required',

        ]);

        $testimonials = Testimonials::find($id);
        $testimonials->name = $request->input('name');
        $testimonials->designation = $request->input('designation');
        $testimonials->message = $request->input('message');
        $testimonials->lang_id = $request->input('lang_id');
        $testimonials->status = $request->input('status');
        if($request->hasfile('image')) 
        {
            $destination = 'uploads/testimonials/' .$testimonials->image;
            if(File::exists($destination)){
                File::delete($destination);
            }

            $file = $request->file('image');
            $extention = $file->getClientOriginalExtension();
            $filename = time(). '.' .$extention;
            $file->move('uploads/testimonials/', $filename);
            $testimonials->image =$filename;
        }
        $testimonials->status = $request->input('status') == true ? '1':'0';
        $testimonials->save();
        return redirect()->back()->with('message', 'Testimonials successfully Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $testimonials = Testimonials::find($id);
        $image = $testimonials['image'];
        $path = public_path()."/uploads/testimonials/".$image;
            if(File::exists($path)) {
                File::delete($path);
            }

        $testimonials->delete($id);
        return redirect()->back()->with('message', 'Testimonials successfully Deleted');
    }

    // status pop up 
    public function statusUpdate($id)
    {   
        $data =  Testimonials::where('id' , $id )->get('status'); 
        $area = json_decode($data, true);
        if($area[0]['status'] == 0)
        {
        $affected = Testimonials::where('id', $id)
                ->update(array('status' => 1));
                return redirect()->back()->with('message', 'Status Updated Successfully');
        }
        else
        {
            $affected = Testimonials::where('id', $id)
                ->update(array('status' => 0));
                return redirect()->back()->with('message', 'Status Updated Successfully');
        }
    }
}
