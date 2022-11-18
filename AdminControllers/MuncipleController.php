<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DistrictMunciple;
use Illuminate\Support\Facades\File;
use Yajra\Datatables\Datatables;

class MuncipleController extends Controller
{
    // Ajax Datatables Messages
    public function ajaxdata(Request $request)
    {
        $data = DistrictMunciple::latest()->get();
        return Datatables::of($data)
            ->addIndexColumn()
            ->editColumn('action', function($row){
                $actionBtn = '<a href="districtmunciple/edit/'.$row->id.'" class="edit btn btn-success btn-sm">
                <i class="fas fa-pencil-alt"></i></a> ';
                return $actionBtn;
            })
            ->editColumn('created_at', function ($row) {
                return date('d-m-Y', strtotime($row->created_at));
            })
            ->editColumn('bg_image', function($row){
                $url=asset("uploads/DistrictMunciple/$row->bg_image");
                $image = '<img src='.$url.' width="300px" height="150px">' ;
                    return $image;
            })
            ->editColumn('lang_id', function($row){
                $en = '<span class="bg-success text-white p-2" style="display: inline-block; font-size: .875rem;">English</span>';
                $ur = '<span class="bg-info text-white p-2" style="display: inline-block; font-size: .875rem;">Urdu</span>';
                $si = '<span class="bg-warning p-2" style="display: inline-block; font-size: .875rem; color: #fff !important;">Sindhi</span>';
                
                $lang_id = [1 => $en, 2 => $ur, 3 => $si];
                return $lang_id[$row->lang_id];
            })
            ->rawColumns(['action', 'lang_id', 'created_at', 'bg_image'])
            ->make(true);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $districtmunciple = DistrictMunciple::all();
        return view('admin.DistrictMunciple.index', compact('districtmunciple'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        return view('admin.DistrictMunciple.add');
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
            'district' => 'required',

        ]);

        $districtmunciple = new DistrictMunciple;
        $districtmunciple->bg_image = $request->input('bg_image');
        $districtmunciple->title = $request->input('title');
        $districtmunciple->district = $request->input('district');
        $districtmunciple->lang_id = $request->input('lang_id');
        if($request->hasfile('bg_image')) 
        {
            $file = $request->file('bg_image');
            $extention = $file->getClientOriginalExtension();
            $filename = time(). '.' .$extention;
            $file->move('uploads/DistrictMunciple/', $filename);
            $districtmunciple->bg_image =$filename;
        }
        $districtmunciple->save();
        return redirect()->back()->with('message', 'District Munciple successfully Added'); 
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
        $districtmunciple = DistrictMunciple::find($id);
         return view('admin.DistrictMunciple.edit', compact('districtmunciple'));
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
            'district' => 'required',

        ]);

        $districtmunciple = DistrictMunciple::find($id);
        $districtmunciple->title = $request->input('title');
        $districtmunciple->district = $request->input('district');
        $districtmunciple->lang_id = $request->input('lang_id');
        if($request->hasfile('bg_image')) 
        {
            $destination = 'uploads/DistrictMunciple/' .$districtmunciple->bg_image;
            if(File::exists($destination)){
                File::delete($destination);
            }

            $file = $request->file('bg_image');
            $extention = $file->getClientOriginalExtension();
            $filename = time(). '.' .$extention;
            $file->move('uploads/DistrictMunciple/', $filename);
            $districtmunciple->bg_image =$filename;
        }
        // Video upload
        if($request->hasfile('video')) 
        {
            $destination = 'uploads/DistrictMunciple/video/' .$districtmunciple->video;
            if(File::exists($destination)){
                File::delete($destination);
            }

            $file = $request->file('video');
            $extention = $file->getClientOriginalExtension();
            $filename = time(). '.' .$extention;
            $file->move('uploads/DistrictMunciple/video/', $filename);
            $districtmunciple->video =$filename;
        }
        $districtmunciple->save();
        return redirect()->back()->with('message', 'District Munciple successfully Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $districtmunciple = DistrictMunciple::find($id);
        $image = $districtmunciple['bg_image'];
        $path = public_path()."/uploads/DistrictMunciple/".$image;
            if(File::exists($path)) {
                File::delete($path);
            }
        $districtmunciple->delete($id);
        return redirect()->back()->with('message', 'District Munciple successfully Deleted');
    }
}
