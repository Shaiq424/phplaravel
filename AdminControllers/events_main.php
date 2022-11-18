<?php

namespace App\Http\Controllers\Admincontrollers;
use App\Http\Controllers\Controller;
use App\Models\Events;
use App\Models\RecentEvent;
use App\Models\Headings;
use Illuminate\Support\Facades\File;
use Yajra\Datatables\Datatables;

use Illuminate\Http\Request;

class events_main extends Controller
{
    // Ajax Datatable Events
    public function ajaxdata(Request $request)
    {
            $data = Events::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('action', function($row){
                    $actionBtn = '<div class="action_btns d-flex justify-content-center"> <a href="events/edit/'.$row->id.'" class="edit btn btn-success btn-sm"><i class="fas fa-pencil-alt"></i></a> 
                    <form action="events/delete/' . $row->id . '" method="GET">
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
                    $si = '<span class="bg-warning p-2" style="display: inline-block; font-size: .875rem; color: #fff !important;">Sindhi</span>';
                    
                    $lang_id = [1 => $en, 2 => $ur, 3 => $si];
                    return $lang_id[$row->lang_id];
                })
                ->editColumn('status', function($row){
                    $active = '<form action="/admin/events_status/' . $row->id . '" method="POST">
                    '.csrf_field().'
                    '.method_field("POST").'
                   <button class="btn btn-success text-white p-2 btn-sm" onclick="return confirm(\'Are you sure you want to update Status ?\')"
                        style="padding: 7px !important;font-size: .875rem; ">Active
                        </button>
                    </form>';
                    $inactive = '<form action="/admin/events_status/' . $row->id . '" method="POST">
                    '.csrf_field().'
                    '.method_field("POST").'
                     <button class="btn btn-danger text-white p-2 btn-sm" onclick="return confirm(\'Are you sure you want to update Status ?\')"
                        style="padding: 7px !important;font-size: .875rem; ">Inactive
                        </button>
                    </form>';
                    $status = [0 => $inactive, 1 => $active];
                    return $status[$row->status];
                })
                ->rawColumns(['action', 'status', 'lang_id', 'created_at'])
                ->make(true);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $headings = Headings::where('type_id', 1)->get();
        $events = Events::all();
        return view('admin.Events.index', compact('events','headings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        return view('admin.Events.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         // Events Insert Query
         $events = new Events;
         $events->name = $request->input('name');
         $events->lang_id = $request->input('lang_id');
         $events->status = $request->input('status');
         $events->status = $request->input('status') == true ? '1':'0';
         $events->save();
 
         // RecentEvent Insert Query 
         foreach($request->file('image') as $file){
             $image = new RecentEvent;
             $image->event_id = $events->id;
             $imageName = $file->getClientOriginalName();
             $file->move('uploads/eventgallery/', $imageName);
             $image->image=$imageName;
             $image->save();
         }
         
         return redirect()->back()->with('message', 'Events successfully Added'); 
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
        $events = Events::with('getImages')
                    ->whereId($id)->first();


// dd($events);
       
         return view('admin.Events.edit', compact('events'));
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
        $events = Events::find($id);
        $events->name = $request->input('name');
         $events->lang_id = $request->input('lang_id');
        $events->status = $request->input('status');
        $events->status = $request->input('status') == true ? '1':'0';
        $events->save();

            if($request->hasfile('image')) 
            {
                foreach($request->file('image') as $file){
                    $image = new RecentEvent;
                    $image->event_id = $events->id;
                    $imageName = $file->getClientOriginalName();
                    $file->move('uploads/eventgallery/', $imageName);
                    $image->image=$imageName;
                    
                    $image->save();
                }
            }
       
            return redirect()->back()->with('message', 'Events successfully Added'); 

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {

        $events = Events::find($id);
        $events->delete($id);
        RecentEvent::where('event_id',$id)->delete();
        return redirect()->back()->with('message', 'Event successfully Deleted');
    }

    public function imagedelete(Request $request ,$id)
    {
        $events = RecentEvent::find($id);
        $image = $events['image'];
        $path = public_path()."/uploads/eventgallery/".$image;
            if(File::exists($path)) {
                File::delete($path);
            }
        $events->delete($id);
       
        return redirect()->back()->with('message', 'Image successfully Deleted');
    }

    public function fetchevent(Request $request)
    {
        if($request->id != 0)
        {
            $events = RecentEvent::where('event_id',$request->id)->get();
            return $events;
        }
        else
        {
            $events = RecentEvent::get();
            return $events;
        }
    }

    // status pop up 
    public function statusUpdate($id)
    {   
        $data =  Events::where('id' , $id )->get('status'); 
        $area = json_decode($data, true);
        if($area[0]['status'] == 0)
        {
        $affected = Events::where('id', $id)
                ->update(array('status' => 1));
                return redirect()->back()->with('message', 'Status Updated Successfully');
        }
        else
        {
            $affected = Events::where('id', $id)
                ->update(array('status' => 0));
                return redirect()->back()->with('message', 'Status Updated Successfully');
        }
    }

}
