<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\ChildMenu;
use App\Models\HeaderMenu;
use App\Models\SubMenu;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class header_menu extends Controller
{
    // Ajax Datatables Footer Menu
    public function ajaxdata(Request $request)
    {
            $data = HeaderMenu::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('action', function($row){
                    $actionBtn = '<div class="action_btns d-flex justify-content-center"> <a href="headermenu/edit/'.$row->id.'" class="edit btn btn-success btn-sm"><i class="fas fa-pencil-alt"></i></a> 
                    
                    <form action="headermenu/delete/' . $row->id . '" method="GET">
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
                ->editColumn('lang_id', function($row){
                    $en = '<span class="bg-success text-white p-2" style="display: inline-block; font-size: .875rem;">English</span>';
                    $ur = '<span class="bg-info text-white p-2" style="display: inline-block; font-size: .875rem;">Urdu</span>';
                    $si = '<span class="bg-warning p-2" style="display: inline-block; font-size: .875rem; color: #fff !important; ">Sindhi</span>';
                    
                    $lang_id = [1 => $en, 2 => $ur, 3 => $si];
                    return $lang_id[$row->lang_id];
                })
                ->editColumn('status', function($row){
                    $active = '<form action="/admin/menu_status/' . $row->id . '" method="POST">
                    '.csrf_field().'
                    '.method_field("POST").'
                   <button class="btn btn-success text-white p-2 btn-sm" onclick="return confirm(\'Are you sure you want to update Status ?\')"
                        style="padding: 7px !important;font-size: .875rem; ">Active
                        </button>
                    </form>';
                    $inactive = '<form action="/admin/menu_status/' . $row->id . '" method="POST">
                    '.csrf_field().'
                    '.method_field("POST").'
                     <button class="btn btn-danger text-white p-2 btn-sm" onclick="return confirm(\'Are you sure you want to update Status ?\')"
                        style="padding: 7px !important;font-size: .875rem; ">Inactive
                        </button>
                    </form>';
                    $status = [0 => $inactive, 1 => $active];
                    return $status[$row->status];
                })
                ->rawColumns(['action', 'lang_id', 'status', 'created_at'])
                ->make(true);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $headermenu = HeaderMenu::all();
        return view('admin.HeaderMenu.index', compact('headermenu'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        return view('admin.HeaderMenu.add');
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

            'title' => 'menu_title',
            'heading' => 'menu_link',
        ]);

        $headermenu = new HeaderMenu;
        $headermenu->menu_title = $request->input('menu_title');
        $headermenu->menu_link = $request->input('menu_link');
        $headermenu->lang_id = $request->input('lang_id');
        $headermenu->status = $request->input('status');
        $headermenu->status = $request->input('status') == true ? '1':'0';
        $headermenu->save();
        return redirect()->back()->with('message', 'Main Menu successfully Added'); 
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
        $headermenu = HeaderMenu::find($id);
         return view('admin.HeaderMenu.edit', compact('headermenu'));
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

            'title' => 'menu_title',
            'heading' => 'menu_link',
        ]);

        $headermenu = HeaderMenu::find($id);
        $headermenu->menu_title = $request->input('menu_title');
        $headermenu->menu_link = $request->input('menu_link');
        $headermenu->lang_id = $request->input('lang_id');
        $headermenu->status = $request->input('status');
        $headermenu->status = $request->input('status') == true ? '1':'0';
        $headermenu->save();
        return redirect()->back()->with('message', 'Main Menu successfully Updated'); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {

        $headermenu = HeaderMenu::find($id);
        $headermenu->delete($id);
        // SubMenu::where('main_menu_id',$id)->delete();
        return redirect()->back()->with('message', 'Main Menu successfully Deleted');
    }

    // status on popup
    public function statusUpdate($id)
    {   
        $data =  HeaderMenu::where('id' , $id )->get('status'); 
        $area = json_decode($data, true);
        if($area[0]['status'] == 0)
        {
        $affected = HeaderMenu::where('id', $id)
                ->update(array('status' => 1));
                return redirect()->back()->with('message', 'Status Updated Successfully');
        }
        else
        {
            $affected = HeaderMenu::where('id', $id)
                ->update(array('status' => 0));
                return redirect()->back()->with('message', 'Status Updated Successfully');
        }
    }
}
