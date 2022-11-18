<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ComplainBox;
use Illuminate\Support\Facades\File;
use Yajra\Datatables\Datatables;

class ComplainBoxController extends Controller
{
    // Ajax datatables function
    public function ajaxdata(Request $request)
    {
       $data = ComplainBox::latest()->get();
       return Datatables::of($data)
           ->addIndexColumn()
           ->editColumn('action', function($row){
               $actionBtn = '<a href="complainbox/edit/'.$row->id.'" class="edit btn btn-success btn-sm"><i class="fas fa-pencil-alt"></i></a>' ;
               return $actionBtn;
           })
           ->editColumn('updated_at', function ($row) {
               return date('d-m-Y', strtotime($row->updated_at));
           })
           ->editColumn('lang_id', function($row){
               $en = '<span class="bg-success text-white p-2" style="display: inline-block; font-size: .875rem;">English</span>';
               $ur = '<span class="bg-info text-white p-2" style="display: inline-block; font-size: .875rem;">Urdu</span>';
               $si = '<span class="bg-warning p-2" style="display: inline-block; font-size: .875rem; color: #fff !important;">Sindhi</span>';
               
               $lang_id = [1 => $en, 2 => $ur, 3 => $si];
               return $lang_id[$row->lang_id];
           })
           
           ->rawColumns(['action', 'updated_at' , 'lang_id'])
           ->make(true);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $complainbox = ComplainBox::all();
        return view('admin.ComplainBox.index', compact('complainbox'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        return view('admin.ComplainBox.add');
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

        ]);

        // dd($request);
        $complainbox = new ComplainBox;
        $complainbox->title = $request->input('title');
        $complainbox->btn_title = $request->input('btn_title');
        $complainbox->description = $request->input('description');
        $complainbox->lang_id = $request->input('lang_id');
        $complainbox->save();
        return redirect()->back()->with('message', 'Complain Box successfully Added');
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
        $complainbox = ComplainBox::find($id);
        return view('admin.ComplainBox.edit', compact('complainbox'));
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
            'description' => 'required',

        ]);
        
        //dd($request);
        $complainbox = ComplainBox::find($id);
        $complainbox->title = $request->input('title');
        $complainbox->btn_title = $request->input('btn_title');
        $complainbox->description = $request->input('description');
        $complainbox->lang_id = $request->input('lang_id');
        $complainbox->save();
        
        return redirect()->back()->with('message', 'Complain Box successfully Update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $complainbox = ComplainBox::find($id);
        $complainbox->delete($id);
        return redirect()->back()->with('message', 'Complain Box successfully Delete');
    }
    

}
