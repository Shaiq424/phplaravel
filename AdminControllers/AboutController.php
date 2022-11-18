<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\About;
use Illuminate\Support\Facades\File;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Str;


class AboutController extends Controller
{
    public function ajaxdata(Request $request)
    {
            $data = About::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('action', function($row){
                    $actionBtn = '<div class="action_btns d-flex justify-content-center"> <a href="about/edit/'.$row->id.'" class="edit btn btn-success btn-sm"><i class="fas fa-pencil-alt"></i></a>'; 
                    return $actionBtn;
                })
                ->editColumn('updated_at', function ($row) {
                    return date('d-m-Y', strtotime($row->updated_at));
                })
                ->editColumn('image', function($row){
                    $url=asset("uploads/about/$row->image");
                    $image = '<img src='.$url.' width="200px">' ;
                     return $image;
                })
                ->editColumn('lang_id', function($row){
                    $en = '<span class="bg-success text-white p-2" style="display: inline-block; font-size: .875rem;">English</span>';
                    $ur = '<span class="bg-info text-white p-2" style="display: inline-block; font-size: .875rem;">Urdu</span>';
                    $si = '<span class="bg-warning p-2" style="display: inline-block; font-size: .875rem; color: #fff !important;">Sindhi</span>';
                    
                    $lang_id = [1 => $en, 2 => $ur, 3 => $si];
                    return $lang_id[$row->lang_id];
                })
                
                ->rawColumns(['action', 'lang_id', 'image', 'updated_at'])
                ->make(true);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $about = About::all();
        return view('admin.Pages.About.index', compact('about'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

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
    public function edit()
    {
        $about = About::first();
         return view('admin.Pages.About.edit', compact('about'));
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
            'heading' => 'required',
            'line_1' => 'required',
            'circle_1_title' => 'required',
            'circle_1_count' => 'required',
            'circle_2_title' => 'required',
            'circle_2_count' => 'required',
            'circle_3_title' => 'required',
            'circle_3_count' => 'required',
        ]);

        $about = About::find($id);
        $about->description = $request->input('description');
        $about->heading = $request->input('heading');
        $about->line_1 = $request->input('line_1');
        $about->circle_1_title = $request->input('circle_1_title');
        $about->circle_1_count = $request->input('circle_1_count');
        $about->circle_2_title = $request->input('circle_2_title');
        $about->circle_2_count = $request->input('circle_2_count');
        $about->circle_3_title = $request->input('circle_3_title');
        $about->circle_3_count = $request->input('circle_3_count');
        $about->lang_id = $request->input('lang_id');
        if($request->hasfile('image')) 
        {
            $destination = 'uploads/about/' .$about->image;
            if(File::exists($destination)){
                File::delete($destination);
            }

            $file = $request->file('image');
            $extention = $file->getClientOriginalExtension();
            $filename = time(). '.' .$extention;
            $file->move('uploads/about/', $filename);
            $about->image =$filename;
        }

        $about->save();
        return redirect()->back()->with('message', 'About successfully Added'); 

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {

        $about = About::find($id);
        $about->delete($id);
        // FunctionsPoints::where('is_function',$id)->delete();
        return redirect()->back()->with('message', 'About successfully Deleted');
    }


    public function statusUpdate($id)
    {   
        $data =  About::where('id' , $id )->get('status'); 
        $area = json_decode($data, true);
        if($area[0]['status'] == 0)
        {
        $affected = About::where('id', $id)
                ->update(array('status' => 1));
                return redirect()->back()->with('message', 'Status Updated Successfully');
        }
        else
        {
            $affected = About::where('id', $id)
                ->update(array('status' => 0));
                return redirect()->back()->with('message', 'Status Updated Successfully');
        }
    }
}

