<?php

namespace App\Http\Controllers\Admincontrollers;
use App\Http\Controllers\Controller;
use App\Models\RecentEvent;
use App\Models\Events;
use Illuminate\Http\Request;
use GuzzleHttp\Psr7\UploadedFile;
use Illuminate\Support\Facades\File;
use Yajra\Datatables\Datatables;

class recent_events extends Controller
{

    // Ajax Datatable News feeds
    public function ajaxdata(Request $request)
    {
            $data = RecentEvent::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('action', function($row){
                    $actionBtn = '<a href="recentevent/edit/'.$row->id.'" class="edit btn btn-success btn-sm">Edit</a> <a href="recentevent/delete/'.$row->id.'" class="delete btn btn-danger btn-sm">Delete</a>';
                    return $actionBtn;
                })
                ->editColumn('event_gallery', function($row){
                    $url=asset("uploads/recentevent/$row->event_gallery");
                    $image = '<img src='.$url.' width="100px" height="100px" style="border-radius: 50%;">' ;
                     return $image;
                })
                ->editColumn('created_at', function ($row) {
                    return date('d-m-Y', strtotime($row->created_at));
                })
                ->editColumn('status', function($row){
                    $active = '<span class="bg-success text-white p-2" style="display: inline-block; font-size: .875rem;">Active</span>';
                    $inactive = '<span class="bg-danger text-white p-2" style="display: inline-block; font-size: .875rem;">Inactive</span>';
                    $status = [0 => $inactive, 1 => $active];
                    return $status[$row->status];
                })
                        
                ->rawColumns(['action', 'event_gallery', 'status', 'created_at'])
                ->make(true);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $recentevent = RecentEvent::all();
        return view('admin.RecentEvents.index', compact('recentevent'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        return view('admin.RecentEvents.add');
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
        $events->featured_image = $request->input('featured_image');
        $events->status = $request->input('status');
        if($request->hasfile('featured_image')) 
        {
            $file = $request->file('featured_image');
            $extention = $file->getClientOriginalExtension();
            $filename = time(). '.' .$extention;
            $file->move('uploads/events/', $filename);
            $events->featured_image =$filename;
        }
        $events->status = $request->input('status') == true ? '1':'0';
        $events->save();

        // RecentEvent Insert Query 
        foreach($request->file('image') as $file){
            $image = new RecentEvent;
            $image->event_id = $events->id;
            $imageName = time().'.'.$file->getClientOriginalName().'.'.random_int(100000, 999999);
            $file->move('uploads/recentevent/', $imageName);
            $image->image=$imageName;
            $image->save();
        }
        
        return redirect()->back()->with('message', 'Recent Events successfully Added'); 
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
        $recentevent = RecentEvent::find($id);
         return view('admin.RecentEvents.edit', compact('recentevent'));
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
        $recentevent = RecentEvent::find($id);
        $recentevent->status = $request->input('status');
        if($request->hasfile('event_gallery')) 
        {
            $destination = 'uploads/recentevent/' .$recentevent->event_gallery;
            if(File::exists($destination)){
                File::delete($destination);
            }
            $file = $request->file('event_gallery');
            $extention = $file->getClientOriginalExtension().'.'.random_int(100000, 999999);
            $filename = time(). '.' .$extention;
            $file->move('uploads/recentevent/', $filename);
            $recentevent->event_gallery =$filename;
        }

        $recentevent->status = $request->input('status') == true ? '1':'0';
        $recentevent->save();
        return redirect()->back()->with('message', 'Recent Events successfully Added'); 

        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $recentevent = RecentEvent::find($id);
        $recentevent->delete($id);
        return redirect()->back()->with('message', 'Recent Events successfully Deleted');
    }
    
}
