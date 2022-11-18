<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\HomeSlider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Yajra\Datatables\Datatables;


class HomeSliderController extends Controller
{
    // Ajax datatables function
    public function ajaxdata(Request $request)
    {
            $data = HomeSlider::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('action', function($row){
                    $actionBtn = '<div class="action_btns d-flex justify-content-center">  <a href="homeslider/edit/'.$row->id.'" class="edit btn btn-success btn-sm"><i class="fas fa-pencil-alt"></i></a>
                    <form action="homeslider/delete/' . $row->id . '" method="GET">
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
                    $url=asset("uploads/Homeslider/$row->image");
                    $image = '<img src='.$url.' width="300px" height="150px" >' ;
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
                    $active = '<form action="/admin/homeslider_status/' . $row->id . '" method="POST">
                    '.csrf_field().'
                    '.method_field("POST").'
                   <button class="btn btn-success text-white p-2 btn-sm" onclick="return confirm(\'Are you sure you want to update Status ?\')"
                        style="padding: 7px !important;font-size: .875rem; ">Active
                        </button>
                    </form>';
                    $inactive = '<form action="/admin/homeslider_status/' . $row->id . '" method="POST">
                    '.csrf_field().'
                    '.method_field("POST").'
                     <button class="btn btn-danger text-white p-2 btn-sm" onclick="return confirm(\'Are you sure you want to update Status ?\')"
                        style="padding: 7px !important;font-size: .875rem; ">Inactive
                        </button>
                    </form>';
                    $status = [0 => $inactive, 1 => $active];
                    return $status[$row->status];
                })
                
                ->rawColumns(['action', 'created_at' , 'lang_id', 'status', 'image' ])
                ->make(true);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $slider = HomeSlider::all();
        return view('admin.HomeSlider.index', compact('slider'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        return view('admin.HomeSlider.add');
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
            'line_1' => 'required',
            'description' => 'required',
            'btn_title' => 'required',
            'btn_link' => 'required',
            'bannerBg' => 'required'

        ]);

        // dd($request);
        $slider = new HomeSlider;
        $slider->title = $request->input('title');
        $slider->line_1 = $request->input('line_1');
        $slider->description = $request->input('description');
        // $slider->image = $request->input('bannerBg');
        $slider->btn_title = $request->input('btn_title');
        $slider->btn_link = $request->input('btn_link');
        $slider->lang_id = $request->input('lang_id');
        $slider->status = $request->input('status');
        if($request->hasfile('bannerBg')) 
        {
            $file = $request->file('bannerBg');
            $extention = $file->getClientOriginalExtension();
            $filename = time(). '.' .$extention;
            $file->move('uploads/Homeslider/', $filename);
            $slider->image =$filename;
        }
        $slider->status = $request->input('status') == true ? '1':'0';
        $slider->save();
        return redirect()->back()->with('message', 'Home Slider successfully Added');   
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
        $slider = HomeSlider::find($id);
        return view('admin.HomeSlider.edit', compact('slider'));
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
            'line_1' => 'required',
            'description' => 'required',
            'btn_title' => 'required',
            'btn_link' => 'required',

        ]);
        
        //dd($request);
        $slider = HomeSlider::find($id);
        $slider->title = $request->input('title');
        $slider->line_1 = $request->input('line_1');
        $slider->description = $request->input('description');
        $slider->btn_title = $request->input('btn_title');
        $slider->btn_link = $request->input('btn_link');
        $slider->lang_id = $request->input('lang_id');
        $slider->status = $request->input('status');
        if($request->hasfile('bannerBg')) 
        {
            
            $destination = 'uploads/Homeslider/' .$slider->image;
            if(File::exists($destination)){
                File::delete($destination);
            }
            $file = $request->file('bannerBg');
            $extention = $file->getClientOriginalExtension();
            $filename = time(). '.' .$extention;
            $file->move('uploads/Homeslider/', $filename);
            $slider->image = $filename;
            
        }
        $slider->status = $request->input('status') == true ? '1':'0';
        $slider->save();
        
        return redirect()->back()->with('message', 'Home Slider successfully Update'); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $slider = HomeSlider::find($id);
        $image = $slider['image'];
        $path = public_path()."/uploads/Homeslider/".$image;
            if(File::exists($path)) {
                File::delete($path);
            }
        $slider->delete($id);
        return redirect()->back()->with('message', 'Home Slider successfully Delete');
    }

    // status pop up 
    public function statusUpdate($id)
    {   
        $data =  HomeSlider::where('id' , $id )->get('status'); 
        $area = json_decode($data, true);
        if($area[0]['status'] == 0)
        {
        $affected = HomeSlider::where('id', $id)
                ->update(array('status' => 1));
                return redirect()->back()->with('message', 'Status Updated Successfully');
        }
        else
        {
            $affected = HomeSlider::where('id', $id)
                ->update(array('status' => 0));
                return redirect()->back()->with('message', 'Status Updated Successfully');
        }
    }
}
