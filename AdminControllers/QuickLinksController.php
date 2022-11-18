<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\QuickLinks;
use Illuminate\Support\Facades\File;
use Yajra\Datatables\Datatables;

class QuickLinksController extends Controller
{
    // Ajax datatables function
    public function ajaxdata(Request $request)
    {
       $data = QuickLinks::latest()->get();
       return Datatables::of($data)
           ->addIndexColumn()
           ->editColumn('action', function($row){
               $actionBtn = '<div class="action_btns d-flex justify-content-center"> <a href="quicklinks/edit/'.$row->id.'" class="edit btn btn-success btn-sm"><i class="fas fa-pencil-alt"></i></a>

               <form action="quicklinks/delete/' . $row->id . '" method="GET">
                '.csrf_field().'
                '.method_field("GET").'
                <button type="submit" class="delete btn btn-danger btn-sm text-white" onclick="return confirm(\'Are you sure you want to Delete ?\')"
                    ><i class="fas fa-trash" aria-hidden="true"></i>
                    </button>
                </form> </div>';
                return $actionBtn;
           })
           ->editColumn('created_at', function ($row) {
               return date('d-m-Y', strtotime($row->updated_at));
           })
           ->editColumn('lang_id', function($row){
               $en = '<span class="bg-success text-white p-2" style="display: inline-block; font-size: .875rem;">English</span>';
               $ur = '<span class="bg-info text-white p-2" style="display: inline-block; font-size: .875rem;">Urdu</span>';
               $si = '<span class="bg-warning p-2" style="display: inline-block; font-size: .875rem; color: #fff !important;">Sindhi</span>';
               
               $lang_id = [1 => $en, 2 => $ur, 3 => $si];
               return $lang_id[$row->lang_id];
           })
            ->editColumn('status', function($row){
                $active = '<form action="/admin/quicklinks_status/' . $row->id . '" method="POST">
                '.csrf_field().'
                '.method_field("POST").'
                <button class="btn btn-success text-white p-2 btn-sm" onclick="return confirm(\'Are you sure you want to update Status ?\')"
                    style="padding: 7px !important;font-size: .875rem; ">Active
                    </button>
                </form>';
                $inactive = '<form action="/admin/quicklinks_status/' . $row->id . '" method="POST">
                '.csrf_field().'
                '.method_field("POST").'
                <button class="btn btn-danger text-white p-2 btn-sm" onclick="return confirm(\'Are you sure you want to update Status ?\')"
                    style="padding: 7px !important;font-size: .875rem; ">Inactive
                    </button>
                </form>';
                $status = [0 => $inactive, 1 => $active];
                return $status[$row->status];
           })
           
           ->rawColumns(['action', 'created_at' , 'lang_id', 'status'])
           ->make(true);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $quicklinks = QuickLinks::all();
        return view('admin.QuickLinks.index', compact('quicklinks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        return view('admin.QuickLinks.add');
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

            'tag_title' => 'required',
            'tag_links' => 'required',

        ]);

        // dd($request);
        $quicklinks = new QuickLinks;
        $quicklinks->tag_title = $request->input('tag_title');
        $quicklinks->tag_links = $request->input('tag_links');
        $quicklinks->lang_id = $request->input('lang_id');
        $quicklinks->status = $request->input('status');
        $quicklinks->status = $request->input('status') == true ? '1':'0';
        $quicklinks->save();
        return redirect()->back()->with('message', 'Quick Links successfully Added');
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
        $quicklinks = QuickLinks::find($id);
        return view('admin.QuickLinks.edit', compact('quicklinks'));
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

            'tag_title' => 'required',
            'tag_links' => 'required',

        ]);
        
        //dd($request);
        $quicklinks = QuickLinks::find($id);
        $quicklinks->tag_title = $request->input('tag_title');
        $quicklinks->tag_links = $request->input('tag_links');
        $quicklinks->lang_id = $request->input('lang_id');
        $quicklinks->status = $request->input('status');
        $quicklinks->status = $request->input('status') == true ? '1':'0';
        $quicklinks->save();
        
        return redirect()->back()->with('message', 'Quick Links successfully Update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $quicklinks = QuickLinks::find($id);
        $quicklinks->delete($id);
        return redirect()->back()->with('message', 'Quick Links successfully Delete');
    }

    // status pop up 
    public function statusUpdate($id)
    {   
        $data =  QuickLinks::where('id' , $id )->get('status'); 
        $area = json_decode($data, true);
        if($area[0]['status'] == 0)
        {
        $affected = QuickLinks::where('id', $id)
                ->update(array('status' => 1));
                return redirect()->back()->with('message', 'Status Updated Successfully');
        }
        else
        {
            $affected = QuickLinks::where('id', $id)
                ->update(array('status' => 0));
                return redirect()->back()->with('message', 'Status Updated Successfully');
        }
    }
}
