<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tender;
use Illuminate\Support\Facades\File;
use Yajra\Datatables\Datatables;

class TenderController extends Controller
{
    public function ajaxdata(Request $request)
    {
            $data = Tender::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('action', function($row){
                    $actionBtn = '<div class="action_btns d-flex justify-content-center">  <a href="tender/edit/'.$row->id.'" class="edit btn btn-success btn-sm"><i class="fas fa-pencil-alt"></i></a> 
                    
                    <form action="tender/delete/' . $row->id . '" method="GET">
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
        $tender = Tender::all();
        return view('admin.tender.index', compact('tender'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        return view('admin.tender.add');
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

            'tender_number' => 'required',
            'tender_name' => 'required',
            'date' => 'required',
            'file' => 'required',

        ]);

        $tender = new tender;
        $tender->tender_number = $request->input('tender_number');
        $tender->tender_name = $request->input('tender_name');
        $tender->date = $request->input('date');
        $tender->file = $request->input('file');
        if($request->hasfile('file')) 
        {
            $file = $request->file('file');
            $extention = $file->getClientOriginalExtension();
            $filename = time(). '.' .$extention;
            $file->move('uploads/tender/pdf', $filename);
            $tender->file =$filename;
        }
        $tender->save();
        return redirect()->back()->with('message', 'Tender successfully Added'); 
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
        $tender = Tender::find($id);
         return view('admin.tender.edit', compact('tender'));
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

            'tender_number' => 'required',
            'tender_name' => 'required',
            'date' => 'required',

        ]);

        $tender = Tender::find($id);
        $tender->tender_number = $request->input('tender_number');
        $tender->tender_name = $request->input('tender_name');
        $tender->date = $request->input('date');
        if($request->hasfile('file')) 
        {
            $destination = 'uploads/tender/' .$tender->file;
            if(File::exists($destination)){
                File::delete($destination);
            }

            $file = $request->file('file');
            $extention = $file->getClientOriginalExtension();
            $filename = time(). '.' .$extention;
            $file->move('uploads/tender/pdf', $filename);
            $tender->file =$filename;
        }
        $tender->save();
        return redirect()->back()->with('message', 'Tender successfully Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $tender = Tender::find($id);
        $tender->delete($id);
        return redirect()->back()->with('message', 'Tender successfully Deleted');
    }
}
