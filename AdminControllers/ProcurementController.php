<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProcurementPlan;
use Illuminate\Support\Facades\File;
use Yajra\Datatables\Datatables;

class ProcurementController extends Controller
{
    public function ajaxdata(Request $request)
    {
            $data = ProcurementPlan::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('action', function($row){
                    $actionBtn = '<div class="action_btns d-flex justify-content-center">  <a href="procurement/edit/'.$row->id.'" class="edit btn btn-success btn-sm"><i class="fas fa-pencil-alt"></i></a> 
                    
                    <form action="procurement/delete/' . $row->id . '" method="GET">
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
        $procurement = ProcurementPlan::all();
        return view('admin.procurement.index', compact('procurement'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        return view('admin.procurement.add');
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

            'description' => 'required',
            'file' => 'required',

        ]);

        $procurement = new ProcurementPlan;
        $procurement->description = $request->input('description');
        $procurement->file = $request->input('file');
        if($request->hasfile('file')) 
        {
            $file = $request->file('file');
            $extention = $file->getClientOriginalExtension();
            $filename = time(). '.' .$extention;
            $file->move('uploads/procurement/pdf', $filename);
            $procurement->file =$filename;
        }
        $procurement->save();
        return redirect()->back()->with('message', 'Procurement Plan successfully Added'); 
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
        $procurement = ProcurementPlan::find($id);
         return view('admin.procurement.edit', compact('procurement'));
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

        ]);

        $procurement = ProcurementPlan::find($id);
        $procurement->description = $request->input('description');
        if($request->hasfile('file')) 
        {
            $destination = 'uploads/procurement/' .$procurement->file;
            if(File::exists($destination)){
                File::delete($destination);
            }

            $file = $request->file('file');
            $extention = $file->getClientOriginalExtension();
            $filename = time(). '.' .$extention;
            $file->move('uploads/procurement/pdf', $filename);
            $procurement->file =$filename;
        }
        $procurement->save();
        return redirect()->back()->with('message', 'Procurement Plan successfully Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $procurement = ProcurementPlan::find($id);
        $procurement->delete($id);
        return redirect()->back()->with('message', 'Procurement Plan successfully Deleted');
    }
}
