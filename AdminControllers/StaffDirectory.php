<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StaffDirectorys;
use Yajra\Datatables\Datatables;

class StaffDirectory extends Controller
{
    public function ajaxdata(Request $request)
    {
            $data = StaffDirectorys::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('action', function($row){
                    $actionBtn = '<div class="action_btns d-flex justify-content-center"> <a href="staff/edit/'.$row->id.'" class="edit btn btn-success btn-sm"><i class="fas fa-pencil-alt"></i></a> 
                    
                    <form action="staff/delete/' . $row->id . '" method="GET">
                    '.csrf_field().'
                    '.method_field("GET").'
                    <button type="submit" class="delete btn btn-danger btn-sm text-white" onclick="return confirm(\'Are you sure you want to Delete ?\')"
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
        $staffdirectory = StaffDirectorys::all();
        return view('admin.staffdirectory.index', compact('staffdirectory'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        return view('admin.staffdirectory.add');
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
            'ext' => 'required',
            'contact' => 'required',
        ]);

        $staffdirectory = new StaffDirectorys;
        $staffdirectory->name = $request->input('name');
        $staffdirectory->designation = $request->input('designation');
        $staffdirectory->ext = $request->input('ext');
        $staffdirectory->contact = $request->input('contact');
        $staffdirectory->save();
        return redirect()->back()->with('message', 'Staff directory successfully Added'); 
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
        $staffdirectory = StaffDirectorys::find($id);
         return view('admin.staffdirectory.edit', compact('staffdirectory'));
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
            'ext' => 'required',
            'contact' => 'required',
        ]);

        $staffdirectory = StaffDirectorys::find($id);
        $staffdirectory->name = $request->input('name');
        $staffdirectory->designation = $request->input('designation');
        $staffdirectory->ext = $request->input('ext');
        $staffdirectory->contact = $request->input('contact');
        $staffdirectory->save();
        return redirect()->back()->with('message', 'Staff directory successfully Updated'); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {

        $staffdirectory = StaffDirectorys::find($id);
        $staffdirectory->delete($id);
        // SubMenu::where('main_menu_id',$id)->delete();
        return redirect()->back()->with('message', 'Staff directory successfully Deleted');
    }
}
