<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Functions;
use App\Models\FunctionsPoints;
use Illuminate\Support\Facades\File;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Str;


class FunctionsController extends Controller
{
    public function ajaxdata(Request $request)
    {
            $data = Functions::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('action', function($row){
                    $actionBtn = '<div class="action_btns d-flex justify-content-center"> <a href="functions/edit/'.$row->id.'" class="edit btn btn-success btn-sm"><i class="fas fa-pencil-alt"></i></a>'; 
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
            
                ->rawColumns(['action', 'lang_id',  'updated_at'])
                ->make(true);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $functions = Functions::all();
        return view('admin.Pages.Functions.index', compact('functions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        return view('admin.Pages.Functions.add');
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
            'heading' => 'required',
        ]);

         // Events Insert Query
         $functions = new Functions;
         $functions->heading = $request->input('heading');
         $functions->lang_id = $request->input('lang_id');
         $functions->status = $request->input('status');
         $functions->status = $request->input('status') == true ? '1':'0';
         $functions->save();
 
         
         return redirect()->back()->with('message', 'Functions successfully Added'); 
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
        $functions = Functions::first();
         return view('admin.Pages.Functions.edit', compact('functions'));
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
            'description' => 'required',
            'title_one' => 'required',
            'title_two' => 'required',
            'title_three' => 'required',
            'title_four' => 'required',
            'title_five' => 'required',
            'title_six' => 'required',
            'title_seven' => 'required',
        ]);

        $functions = Functions::find($id);
        $functions->description = $request->input('description');
        $functions->title_one = $request->input('title_one');
        $functions->title_two = $request->input('title_two');
        $functions->title_three = $request->input('title_three');
        $functions->title_four = $request->input('title_four');
        $functions->title_five = $request->input('title_five');
        $functions->title_six = $request->input('title_six');
        $functions->title_seven = $request->input('title_seven');
        $functions->lang_id = $request->input('lang_id');

        $functions->save();
        return redirect()->back()->with('message', 'Functions successfully Added'); 

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {

        $functions = Functions::find($id);
        $functions->delete($id);
        // FunctionsPoints::where('is_function',$id)->delete();
        return redirect()->back()->with('message', 'Functions successfully Deleted');
    }


    public function statusUpdate($id)
    {   
        $data =  Functions::where('id' , $id )->get('status'); 
        $area = json_decode($data, true);
        if($area[0]['status'] == 0)
        {
        $affected = Functions::where('id', $id)
                ->update(array('status' => 1));
                return redirect()->back()->with('message', 'Status Updated Successfully');
        }
        else
        {
            $affected = Functions::where('id', $id)
                ->update(array('status' => 0));
                return redirect()->back()->with('message', 'Status Updated Successfully');
        }
    }
}

