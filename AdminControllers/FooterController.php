<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Footer;
use Illuminate\Support\Facades\File;
use Yajra\Datatables\Datatables;

class FooterController extends Controller
{
     // Ajax datatables function
     public function ajaxdata(Request $request)
     {
        $data = Footer::latest()->get();
        return Datatables::of($data)
            ->addIndexColumn()
            ->editColumn('action', function($row){
                $actionBtn = '<a href="footer/edit/'.$row->id.'" class="edit btn btn-success btn-sm"><i class="fas fa-pencil-alt"></i></a>' ;
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
        $footer = Footer::all();
        return view('admin.Footer.index', compact('footer'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        return view('admin.Footer.add');
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

            'copy_right' => 'required',
            'complain' => 'required',

        ]);

        // dd($request);
        $footer = new Footer;
        $footer->copy_right = $request->input('copy_right');
        $footer->complain = $request->input('complain');
        $footer->lang_id = $request->input('lang_id');
        $footer->save();
        return redirect()->back()->with('message', 'Footer Content successfully Added');
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
        $footer = Footer::find($id);
        return view('admin.Footer.edit', compact('footer'));
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

            'copy_right' => 'required',
            'complain' => 'required',

        ]);
        
        //dd($request);
        $footer = Footer::find($id);
        $footer->complain = $request->input('complain');
        $footer->copy_right = $request->input('copy_right');
        $footer->lang_id = $request->input('lang_id');
        $footer->save();
        
        return redirect()->back()->with('message', 'Footer Content successfully Update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $footer = Footer::find($id);
        $footer->delete($id);
        return redirect()->back()->with('message', 'Footer Content successfully Delete');
    }

    
}
