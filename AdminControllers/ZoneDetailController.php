<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\ZoneDetail;
use App\Models\Zone;
use Yajra\Datatables\Datatables;

class ZoneDetailController extends Controller
{

    // Ajax Datatables Footer Menu
    public function ajaxdata(Request $request)
    {
            $data = ZoneDetail::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('action', function($row){
                    $actionBtn = '<div class="action_btns d-flex justify-content-center"> <a href="zonedetail/edit/'.$row->id.'" class="edit btn btn-success btn-sm"><i class="fas fa-pencil-alt"></i></a> 
                    
                    <form action="zonedetail/delete/' . $row->id . '" method="GET">
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
                ->editColumn('is_zone', function($row){
                    $zone =  Zone::where('id',$row->is_zone)->first('zone_head');
                    $is_zone = $zone->zone_head;
                    return $is_zone;
                 })
                 ->editColumn('status', function($row){
                    $active = '<form action="/admin/zonedetail_status/' . $row->id . '" method="POST">
                    '.csrf_field().'
                    '.method_field("POST").'
                   <button class="btn btn-success text-white p-2 btn-sm" onclick="return confirm(\'Are you sure you want to update Status ?\')"
                        style="padding: 7px !important;font-size: .875rem;">Active
                        </button>
                    </form>';
                    $inactive = '<form action="/admin/zonedetail_status/' . $row->id . '" method="POST">
                    '.csrf_field().'
                    '.method_field("POST").'
                     <button class="btn btn-danger text-white p-2 btn-sm" onclick="return confirm(\'Are you sure you want to update Status ?\')"
                        style="padding: 7px !important;font-size: .875rem;">Inactive
                        </button>
                    </form>';
                    $status = [0 => $inactive, 1 => $active];
                    return $status[$row->status];
                })
                ->rawColumns(['action', 'lang_id', 'status', 'is_zone', 'created_at'])
                ->make(true);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $zonedetail = ZoneDetail::all();
        return view('admin.Pages.Zone.ZoneDetail.index', compact('zonedetail'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        $zone = Zone::all();
        $zonedetail = ZoneDetail::get();
        return view('admin.Pages.Zone.ZoneDetail.add', compact('zonedetail', 'zone'));
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
            'uc_number' => 'required',
            'uc_name' => 'required',
        ]);

        $zonedetail = new ZoneDetail();
        $zonedetail->is_zone = $request->input('is_zone');
        $zonedetail->uc_number = $request->input('uc_number');
        $zonedetail->uc_name = $request->input('uc_name');
        $zonedetail->lang_id = $request->input('lang_id');
        $zonedetail->status = $request->input('status');
        $zonedetail->status = $request->input('status') == true ? '1':'0';
        $zonedetail->save();
        return redirect()->back()->with('message', 'Zone Detail successfully Added'); 
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
        $zone = Zone::get();
        $zonedetail = ZoneDetail::find($id);
        return view('admin.Pages.Zone.ZoneDetail.edit', compact('zonedetail', 'zone'));
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
            'uc_number' => 'required',
            'uc_name' => 'required',
        ]);

        $zonedetail = ZoneDetail::find($id);
        $zonedetail->is_zone = $request->input('is_zone');
        $zonedetail->uc_number = $request->input('uc_number');
        $zonedetail->uc_name = $request->input('uc_name');
        $zonedetail->lang_id = $request->input('lang_id');
        $zonedetail->status = $request->input('status');
        $zonedetail->status = $request->input('status') == true ? '1':'0';
        $zonedetail->save();
        return redirect()->back()->with('message', 'Zone Detail successfully Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $zonedetail = ZoneDetail::find($id);
        $zonedetail->delete($id);
        return redirect()->back()->with('message', 'Zone Detail successfully Deleted');
    }

    public function statusUpdate($id)
    {   
        $data =  ZoneDetail::where('id' , $id )->get('status'); 
        $area = json_decode($data, true);
        if($area[0]['status'] == 0)
        {
        $affected = ZoneDetail::where('id', $id)
                ->update(array('status' => 1));
                return redirect()->back()->with('message', 'Status Updated Successfully');
        }
        else
        {
            $affected = ZoneDetail::where('id', $id)
                ->update(array('status' => 0));
                return redirect()->back()->with('message', 'Status Updated Successfully');
        }
    }
}
