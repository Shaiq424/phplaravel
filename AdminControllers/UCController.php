<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UC;
use Yajra\Datatables\Datatables;

class UCCOntroller extends Controller
{
    public function ajaxdata(Request $request)
    {
            $data = UC::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('action', function($row){
                    $actionBtn = '<div class="action_btns d-flex justify-content-center"> <a href="uc/edit/'.$row->id.'" class="edit btn btn-success btn-sm"><i class="fas fa-pencil-alt"></i></a> 
                    
                    <form action="uc/delete/' . $row->id . '" method="GET">
                    '.csrf_field().'
                    '.method_field("GET").'
                    <button type="submit" class="delete btn btn-danger btn-sm tuc_name-white" onclick="return confirm(\'Are you sure you want to Delete ?\')"
                        ><i class="fas fa-trash" aria-hidden="true"></i>
                        </button>
                    </form> </div>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $uc = UC::all();
        return view('admin.uc.index', compact('uc'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        return view('admin.uc.add');
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

            'zone' => 'required',
            'uc_number' => 'required',
            'uc_name' => 'required',
        ]);

        $uc = new UC;
        $uc->zone = $request->input('zone');
        $uc->uc_number = $request->input('uc_number');
        $uc->uc_name = $request->input('uc_name');
        $uc->save();
        return redirect()->back()->with('message', 'uc directory successfully Added'); 
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
        $uc = UC::find($id);
         return view('admin.uc.edit', compact('uc'));
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

            'zone' => 'required',
            'uc_number' => 'required',
            'uc_name' => 'required',
        ]);

        $uc = UC::find($id);
        $uc->zone = $request->input('zone');
        $uc->uc_number = $request->input('uc_number');
        $uc->uc_name = $request->input('uc_name');
        $uc->save();
        return redirect()->back()->with('message', 'uc directory successfully Updated'); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {

        $uc = UC::find($id);
        $uc->delete($id);
        // SubMenu::where('main_menu_id',$id)->delete();
        return redirect()->back()->with('message', 'uc directory successfully Deleted');
    }
}
