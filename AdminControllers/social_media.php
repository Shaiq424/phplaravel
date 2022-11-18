<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SocialMedia;
use Yajra\Datatables\Datatables;

class social_media extends Controller
{

    // Ajax Datatables Social media
    public function ajaxdata(Request $request)
    {
            $data = SocialMedia::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('action', function($row){
                    $actionBtn = '<a href="socialmedia/edit/'.$row->id.'" class="edit btn btn-success btn-sm">Edit</a>';
                    return $actionBtn;
                })
                ->editColumn('updated_at', function ($row) {
                    return date('d-m-Y', strtotime($row->updated_at));
                })
                ->editColumn('status', function($row){
                    $active = '<span class="bg-success text-white p-2" style="display: inline-block; font-size: .875rem;">Active</span>';
                    $inactive = '<span class="bg-danger text-white p-2" style="display: inline-block; font-size: .875rem;">Inactive</span>';
                    $status = [0 => $inactive, 1 => $active];
                    return $status[$row->status];
                })
                ->rawColumns(['action', 'status', 'updated_at'])
                ->make(true);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $socialmedia = SocialMedia::all();
        return view('admin.SocialMedia.index', compact('socialmedia'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        return view('admin.SocialMedia.add');
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

            'fb_link' => 'required',
            'twit_link' => 'required',
            'linked_link' => 'required',
            'youtube_link' => 'required',

        ]);

        $socialmedia = new SocialMedia;
        $socialmedia->facebook_link = $request->input('fb_link');
        $socialmedia->twitter_link = $request->input('twit_link');
        $socialmedia->linkedin_link = $request->input('linked_link');
        $socialmedia->youtube_link = $request->input('youtube_link');
        $socialmedia->save();
        return redirect()->back()->with('message', 'Social Media Links successfully Added'); 
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
    public function edit()
    {
        $socialmedia = SocialMedia::first();
         return view('admin.SocialMedia.edit', compact('socialmedia'));
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

            'fb_link' => 'required',
            'twit_link' => 'required',
            'linked_link' => 'required',
            'youtube_link' => 'required',

        ]);
        
        $socialmedia = SocialMedia::first();
        $socialmedia->facebook_link = $request->input('fb_link');
        $socialmedia->twitter_link = $request->input('twit_link');
        $socialmedia->linkedin_link = $request->input('linked_link');
        $socialmedia->youtube_link = $request->input('youtube_link');
        $socialmedia->save();
        return redirect()->back()->with('message', 'Social Media Links successfully Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $socialmedia = SocialMedia::find($id);
        $socialmedia->delete($id);
        return redirect()->back()->with('message', 'Social Media Links successfully Deleted');
    }
    
}
